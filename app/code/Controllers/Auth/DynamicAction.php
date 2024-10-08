<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Auth;

use Psr\Log\LogLevel;
use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Services\LoggerServerInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Site1\Api\Services\PasswordCheckInterface;
use \Romchik38\Site1\Api\Services\SessionInterface;
use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;
use Romchik38\Server\Models\Errors\CouldNotSaveException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Services\UserRegisterInterface;
use Romchik38\Site1\Services\Errors\UserRegister\IncorrectFieldError;
use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;
use Romchik38\Site1\Services\Errors\UserRecoveryEmail\CantSendRecoveryLinkException;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;
use Romchik38\Site1\Api\Services\RecaptchaInterface;
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
        private readonly PasswordCheckInterface $passwordCheck,
        private readonly SessionInterface $session,
        private readonly UserRegisterInterface $userRegister,
        private readonly UserRecoveryEmailInterface $userRecoveryEmail,
        private readonly UserRepositoryInterface $userRepository,
        protected readonly RecaptchaInterface $recaptchaService,
        protected LoggerServerInterface $logger,
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
        // 1. Get Request Data
        $password = $this->request->getPassword();
        $userName = $this->request->getUserName();
        if ($userName === '' || $password === '') {
            return $this->failedMessage;
        }

        $userId = $this->passwordCheck->checkCredentials($userName, $password);
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
    protected function changepassword()
    {
        // 1 check auth
        $userId = $this->session->getUserId();

        if ($userId === 0) {
            return $this->changepasswordFailedMessage;
        }
        // 2 check if field is present
        $password = $this->request->getPassword();
        if ($password === '') {
            return $this->changepasswordBadRequest;
        }
        // 3 check password requirements
        try {
            $this->userRegister->checkPasswordChange($password);
        } catch (IncorrectFieldError $e) {
            return $e->getMessage();
        }
        // 4 set new password
        $changeResult = $this->userRegister->changepassword($userId, $password);
        if ($changeResult === false) {
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
        /** 1. Emeil present check */
        $email = $this->request->getEmail();
        if ($email === '') {
            return 'Bad request (email not present)';
        }

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
                    return $this->weWillSend($email);
                }
            } catch (RecaptchaException $e) {
                $this->logger->log(LogLevel::ERROR, $this::class . ': Error while checking recaptcha. Service said - ' . $e->getMessage());
                return $this->technicalIssues;
            }
        }

        /* 3. Check if email is present in the database */
        try {
            $this->userRepository->getByEmail($email);
        } catch (NoSuchEntityException $e) {
            return $this->weWillSend($email);
        }

        /*  4. Send an email */
        try {
            $this->userRecoveryEmail->sendRecoveryLink($email);
            return $this->weWillSend($email);
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
        // 1 Check username availability
        $userName = $this->request->getUserName();
        if ($userName === '') {
            return 'Bad request (username not present)';
        }
        $isAvailable = $this->userRegister->checkAvailableUsername($userName);
        if ($isAvailable === false) {
            return 'Sorry, username ' . $userName . '  already in use';
        }
        // 2 If Error
        $userRegisterDTO = $this->request->getUserRegisterData();
        try {
            $this->userRegister->checkUserInformation($userRegisterDTO);
        } catch (IncorrectFieldError $e) {
            return $e->getMessage();
        }
        // 3 Ok
        try {
            $user = $this->userRegister->register($userRegisterDTO);
            $this->session->setUserId($user->getId());
            $this->logger->log(LogLevel::DEBUG, $this::class . ': user with id ' . $user->getId() . ' successfully registered');
            return 'You are successfully registered. Please login';
        } catch (CouldNotSaveException $e) {
            $this->logger->log(
                LogLevel::ERROR,
                $this::class . ': Error while saving new user - ' . $e->getMessage()
            );
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
