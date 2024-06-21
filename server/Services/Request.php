<?php

declare(strict_types=1);

namespace Romchik38\Server\Services;

use Romchik38\Server\Api\Services\RequestInterface;

class Request implements RequestInterface {

    public function getPassword(): string
    {
        return $_POST[RequestInterface::PASSWORD_FIELD] ?? '';
    }

    public function getUserName(): string
    {
        return $_POST[RequestInterface::USERNAME_FIELD] ?? '';
    }
}