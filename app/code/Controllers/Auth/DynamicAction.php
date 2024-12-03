<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Auth;

use Psr\Log\LogLevel;
use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Services\LoggerServerInterface;
use Romchik38\Server\Api\Services\MailerInterface;
use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Controllers\Errors\DynamicActionNotFoundException;
use Romchik38\Server\Models\DTO\Email\EmailDTO;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Services\Errors\CantSendEmailException;
use Romchik38\Site1\Api\Services\RecaptchaInterface;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Services\SessionInterface;
use Romchik38\Site1\Application\RecoveryEmail\CantCreateHashException;
use Romchik38\Site1\Application\RecoveryEmail\Create;
use Romchik38\Site1\Application\RecoveryEmail\RecoveryEmailService;
use Romchik38\Site1\Application\UserChangePassword\Change;
use Romchik38\Site1\Application\UserChangePassword\CouldNonChangePassword;
use Romchik38\Site1\Application\UserChangePassword\UserChangePasswordService;
use Romchik38\Site1\Application\UserEmail\FindEmail;
use Romchik38\Site1\Application\UserEmail\NoSuchEmailException;
use Romchik38\Site1\Application\UserEmail\UserEmailService;
use Romchik38\Site1\Application\UserPasswordCheck\Credentials;
use Romchik38\Site1\Application\UserPasswordCheck\UserPasswordCheckService;
use Romchik38\Site1\Application\EntityRecoveryEmail\CreateEmailTemplate;
use Romchik38\Site1\Application\EntityRecoveryEmail\EntityRecoveryEmailService;
use Romchik38\Site1\Application\UserRegister\CouldNotRegisterException;
use Romchik38\Site1\Application\UserRegister\Register;
use Romchik38\Site1\Application\UserRegister\UsernameAlreadyInUseException;
use Romchik38\Site1\Application\UserRegister\UserRegisterService;
use Romchik38\Site1\Services\Errors\Recaptcha\RecaptchaException;

class DynamicAction extends Action implements DynamicActionInterface
{
    private array $methods = [
        'index',
        'logout',
        'register',
        'recovery',
        'changepassword'
    ];

    private $successMessage = 'Authentication success';
    private $failedMessage = 'Authentication failed';
    private $logoutMessageSuccess = 'You have loged out';
    private $logoutMessageFailed = 'You must be loged in before log out';
    private $changepasswordFailedMessage = 'You must be logged in to change a password';
    private $changepasswordBadRequest = 'Bad request ( no password provided )';
    private $technicalIssues = 'We are sorry. There are some technical issues on our side. Please try later.';
    private $changePasswordSuccessMessage = 'Your password was changed successfully';

    public function __construct(
        private readonly RequestInterface $request,
        private readonly UserPasswordCheckService $passwordCheck,
        private readonly SessionInterface $session,
        private readonly UserRegisterService $userRegister,
        private readonly EntityRecoveryEmailService $entityRecoveryEmailService,
        protected readonly RecaptchaInterface $recaptchaService,
        protected LoggerServerInterface $logger,
        protected readonly UserChangePasswordService $userChangePassword,
        protected readonly UserEmailService $userEmailService,
        protected readonly RecoveryEmailService $recoveryEmailService,
        protected MailerInterface $mailer,
        protected array $recaptchas = []
    ) {}

    public function execute(string $action): string
    {
        if (array_search($action, $this->methods) !== false) {
            return $this->$action();
        } else {
            throw new DynamicActionNotFoundException('Sorry, requested resource ' . $action . ' not found');
        }
    }

    public function getRoutes(): array
    {
        return $this->methods;
    }

    /**
     * Action /auth/index
     */
    protected function index(): string
    {
        $hash = $this->request->getParsedBody();
        $command = Credentials::fromRequest($hash);
        try {
            $userId = $this->passwordCheck->checkCredentials($command);
        } catch (InvalidArgumentException) {
            return $this->failedMessage;
        }

        if ($userId > 0) {
            $this->session->setUserId($userId);
            return $this->successMessage;
        } else {
            return $this->failedMessage;
        }
    }

    /**
     * Action changepassword
     */
    protected function changepassword(): string
    {
        // 1 check auth
        $userId = $this->session->getUserId();

        if ($userId === 0) {
            return $this->changepasswordFailedMessage;
        }
        // 2 check if field is present
        $command = Change::fromRequest($userId, $this->request->getParsedBody());
        // 3 check password requirements
        try {
            $this->userChangePassword->changepassword($command);
        } catch (InvalidArgumentException) {
            return $this->changepasswordBadRequest;
        } catch (CouldNonChangePassword) {
            return $this->technicalIssues;
        }

        return $this->changePasswordSuccessMessage;
    }

    /**
     * Action /auth/logout
     */
    protected function logout()
    {
        $userId = $this->session->getUserId();

        if ($userId > 0) {
            $this->session->logout();
            return $this->logoutMessageSuccess;
        }

        return $this->logoutMessageFailed;
    }

    /**
     * Action /auth/recovery
     */
    protected function recovery()
    {
        $command = FindEmail::fromRequest($this->request->getParsedBody());

        /** Recaptcha check */
        $recaptchas = $this->recaptchas['recovery'] ?? [];
        $countRecaptchas = count($recaptchas);
        if ($countRecaptchas > 1) {
            throw new MissingRequiredParameterInFileError(
                'Check config for action auth/recovery: wrong count action names (expected 1 or 0)'
            );
        } elseif ($countRecaptchas === 1) {
            try {
                $result = $this->recaptchaService->checkReCaptcha($recaptchas[0]);
                if ($result === false) {
                    return $this->weWillSend($command->email);
                }
            } catch (RecaptchaException $e) {
                $this->logger->log(LogLevel::ERROR, $this::class . ': Error while checking recaptcha. Service said - ' . $e->getMessage());
                return $this->technicalIssues;
            }
        }

        /*  Email check */
        try {
            $user = $this->userEmailService->checkEmailForRecovery($command);
        } catch (InvalidArgumentException $e) {
            return 'Check recovery parameters: ' . $e->getMessage();
        } catch (NoSuchEmailException) {
            return $this->weWillSend($command->email);
        }

        /** Create a hash */
        try {

            $hash = $this->recoveryEmailService->createHash(
                new Create($user->email)
            );
        } catch (InvalidArgumentException $e) {
            return 'Check recovery parameters: ' . $e->getMessage();
        } catch (CantCreateHashException $e) {
            return $this->technicalIssues;
        }

        $template = $this->entityRecoveryEmailService->createEmailTemplate(
            new CreateEmailTemplate(
                $user->email,
                $user->firstname,
                $hash()
            )
        );

        try {
            $this->mailer->send(new EmailDTO(
                $user->email,
                $template->subject,
                $template->message,
                $template->headers
            ));
            $this->logger->log(LogLevel::DEBUG, 'Recovery email for user ' . $user->email . ' was sent');
            return 'Recovery email was sent. Please check your mailbox and follow instructions';
        } catch (CantSendEmailException $e) {
            $this->logger->log(LogLevel::ERROR, 'Recovery email to <' . $user->email . '> was not sent. Mailer said: ' . $e->getMessage());
            return $this->technicalIssues;
        }
    }

    /**
     * Action /auth/register
     */
    protected function register()
    {
        $command = Register::fromRequest($this->request->getParsedBody());

        try {
            $userId = $this->userRegister->register($command);
            $this->session->setUserId($userId());
            $this->logger->log(LogLevel::DEBUG, $this::class . ': user with id ' . $userId() . ' successfully registered');
            return 'You are successfully registered. Please login';
        } catch (InvalidArgumentException $e) {
            return $e->getMessage();
        } catch (UsernameAlreadyInUseException) {
            return 'Sorry, username ' . $command->username . '  already in use';
        } catch (CouldNotRegisterException $e) {
            return 'Could not register. Please try later';
        }
    }

    protected function weWillSend($email): string
    {
        return 'We will send recovery instructions to '
            . $email
            . ' if it was provided during registration ( Please, check your email box )';
    }
}
