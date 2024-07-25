<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Changepassword;

use Romchik38\Server\Api\Controllers\ControllerInterface;

class Index implements ControllerInterface {
    private array $methods = [
        'index',
        'recovery'
    ];

    public function execute($action): string {

        return 'Hello from Change password - ' . $action;
    }
}