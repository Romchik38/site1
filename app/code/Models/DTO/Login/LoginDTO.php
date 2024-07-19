<?php

namespace Romchik38\Site1\Models\DTO\Login;

use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Models\User\UserModelInterface;

class LoginDTO extends DTO implements LoginDTOInterface {

    public function __construct(
        string $action,
        string $message,
        UserModelInterface|null $user
    )
    {
        $this->data[$this::ACTION_FIELD_NAME] = $action;
        $this->data[RequestInterface::MESSAGE_FIELD] = $message;
        $this->data[LoginDTOInterface::USER_FIELD] = $user;
    }

    public function getActionName(): string {
        return $this->getData($this::ACTION_FIELD_NAME);
    }

    public function getMessage(): string {
        return $this->getData(RequestInterface::MESSAGE_FIELD);
    }

    public function getUser(): UserModelInterface|null {
        return $this->getData(LoginDTOInterface::USER_FIELD);
    }
}