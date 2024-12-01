<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Auth;

use Psr\Log\LogLevel;
use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Services\LoggerServerInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use \Romchik38\Site1\Api\Services\SessionInterface;
use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;
use Romchik38\Site1\Services\Errors\UserRecoveryEmail\CantSendRecoveryLinkException;
use Romchik38\Site1\Api\Services\RecaptchaInterface;
use Romchik38\Site1\Application\UserChangePassword\Change;
use Romchik38\Site1\Application\UserChangePassword\CouldNonChangePassword;
use Romchik38\Site1\Application\UserChangePassword\UserChangePassword;
use Romchik38\Site1\Application\UserPasswordCheck\Credentials;
use Romchik38\Site1\Application\UserPasswordCheck\UserPasswordCheckService;
use Romchik38\Site1\Application\UserRecoveryEmail\NoSuchEmailException;
use Romchik38\Site1\Application\UserRecoveryEmail\RecoveryEmail;
use Romchik38\Site1\Application\UserRecoveryEmail\SendEmail;
use Romchik38\Site1\Application\UserRecoveryEmail\UserRecoveryEmailService;
use Romchik38\Site1\Application\UserRegister\CouldNotRegisterException;
use Romchik38\Site1\Application\UserRegister\Register;
use Romchik38\Site1\Application\UserRegister\UsernameAlreadyInUseException;
use Romchik38\Site1\Application\UserRegister\UserRegisterService;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;
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
        private readonly UserRecoveryEmailService $userRecoveryEmail,
        private readonly UserRepositoryInterface $userRepository,
        protected readonly RecaptchaInterface $recaptchaService,
        protected LoggerServerInterface $logger,
        protected readonly UserChangePassword $userChangePassword,
        protected array $recaptchas = []
    ) {}

    public function execute(string $action): string
    {
        if (array_search($action, $this->methods) !== false) {
            return $this->$action();
        } else {
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        }
    }

    public function getRoutes(): array
    {
        return $this->methods;
    }

    /**
     * Action /auth/index
     */
    protected function index()
    {
        $command = Credentials::fromRequest($this->request->getQueryParams());
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
        $command = Change::fromRequest($userId, $this->request->getQueryParams());
        // 3 check password requirements
        try {
            // $this->userRegister->checkPasswordChange($password);
            $this->userChangePassword->changepassword($command);
        } catch (InvalidArgumentException) {
            return $this->changepasswordBadRequest;
        } catch (CouldNonChangePassword $e) {
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
        /** 1. Email present check */
        $command = RecoveryEmail::fromRequest($this->request->getQueryParams());

        /** 2. Recaptcha check */
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

        /*  4. Send an email */
        try {
            $this->userRecoveryEmail->sendRecoveryLink($command);
            return $this->weWillSend($command->email);
        } catch(InvalidArgumentException $e){
            return 'Check recovery parameters: ' . $e->getMessage();
        } catch(NoSuchEmailException) {
            return $this->weWillSend($command->email);
        } catch (CantSendRecoveryLinkException $e) {
            $this->logger->log(
                LogLevel::ERROR,
                $this::class
                    . ': Error while sending recovery email. Recovery Service said - '
                    . $e->getMessage()
            );
            return $this->technicalIssues;
        }
    }

    /**
     * Action /auth/register
     */
    protected function register()
    {
        $command = Register::fromRequest($this->request->getQueryParams());

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
