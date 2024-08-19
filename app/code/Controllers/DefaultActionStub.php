<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\Action;

class DefaultActionStub extends Action implements DefaultActionInterface {
    public function execute(): string
    {
        return 'No route';
    }
}