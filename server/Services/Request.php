<?php

declare(strict_types=1);

namespace Romchik38\Server\Services;

use Romchik38\Server\Api\Services\RequestInterface;

class Request implements RequestInterface {

    public function getMessage(): string
    {
        return $_GET[RequestInterface::MESSAGE_FIELD] 
            ?? $_POST[RequestInterface::MESSAGE_FIELD]
            ?? '';
    }

    public function getPassword(): string
    {
        return $_POST[RequestInterface::PASSWORD_FIELD] ?? '';
    }

    public function getUserName(): string
    {
        return $_POST[RequestInterface::USERNAME_FIELD] ?? '';
    }
}