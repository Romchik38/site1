<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Auth;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Services\RequestInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;

class Index implements ControllerInterface {
    private array $methods = [
        'index'
    ];

    public function __construct(
        private RequestInterface $request
    )
    {
        
    }

    public function execute(string $action): string
    {
        if (array_search($action, $this->methods) !== false) {
            $this->$action();
        } else {
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        }

        return '';
    }

    private function index(){
        // 1. Get Request Data
        $password = $this->request->getPassword();
        $userName = $this->request->getUserName();
        if ($userName = 'ser' && $password = '123') {
            return 'Authentication  success';
        }
        // 2. Get User Repository
        // 3. Check

        // Passed
            // 1. set Session userId
            // 2. redirect to /login/index

        // Not passed
            // 1. redirect to /login/index with error message
    }
}