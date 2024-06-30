<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Auth;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Site1\Api\Services\PasswordCheckInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Models\Errors\CouldNotSaveException;
use Romchik38\Site1\Api\Services\UserRegisterInterface;
use Romchik38\Site1\Services\Errors\UserRegister\IncorrectFieldError;

class Index implements ControllerInterface
{
    private array $methods = [
        'index',
        'logout',
        'register'
    ];

    private $successMessage = 'Authentication success';
    private $failedMessage = 'Authentication failed';
    private $logoutMessageSuccess = 'You have loged out';
    private $logoutMessageFailed = 'You must be loged in before log out';

    public function __construct(
        private RequestInterface $request,
        private PasswordCheckInterface $passwordCheck,
        private SessionInterface $session,
        private UserRegisterInterface $userRegister
    ) {
    }

    public function execute(string $action): string
    {
        if (array_search($action, $this->methods) !== false) {
            return $this->$action();
        } else {
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        }
    }

    /**
    * Action /auth/index
    */
    private function index()
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
    * Action /auth/logout
    */
    private function logout(){
        $userId = $this->session->getUserId();
            
        if ($userId > 0) {
            $this->session->logout();
            return $this->logoutMessageSuccess;
        }

        return $this->logoutMessageFailed;
    }

    /**
    * Action /auth/register
    */
    public function register(){
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
            $this->userRegister->register($userRegisterDTO);
            return 'You are successfully registered. Please login';
        } catch (CouldNotSaveException $e) {
            // do  some log
            
            // send answer
            return 'Could not register. Please try later';
        }
    }
}
