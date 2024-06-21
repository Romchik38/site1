<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Auth;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Services\RequestInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Server\Api\Services\PasswordCheckInterface;

class Index implements ControllerInterface
{
    private array $methods = [
        'index'
    ];

    private $successMessage = 'Authentication success';
    private $failedMessage = 'Authentication failed';

    public function __construct(
        private RequestInterface $request,
        private PasswordCheckInterface $passwordCheck
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

    private function index()
    {
        // 1. Get Request Data
        $password = $this->request->getPassword();
        $userName = $this->request->getUserName();
        if ($userName === '' || $password === '') {
            return $this->failedMessage;
        }

        $result = $this->passwordCheck->checkCredentials($userName, $password);
        if ($result) {
            return $this->successMessage;
        } else {
            return $this->failedMessage;
        }
        // Passed
        // 1. set Session userId
        // 2. redirect to /login/index

        // Not passed
        // 1. redirect to /login/index with error message
    }
}
