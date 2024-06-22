<?php

namespace Romchik38\Site1\Models\DTO\Login;

use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use Romchik38\Server\Models\Model;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Models\User\UserModelInterface;

class LoginDTO extends Model implements LoginDTOInterface {
    public function getActionName(): string {
        return $this->getData($this::ACTION_FIELD_NAME);
    }

    public function getMessage(): string {
        return $this->getData(RequestInterface::MESSAGE_FIELD);
    }

    public function getUser(): UserModelInterface|null {
        return $this->getData(LoginDTOInterface::USER_FIELD);
    }

    public function setActionName(string $action): LoginDTOInterface
    {
        $this->setData($this::ACTION_FIELD_NAME, $action);
        return $this;
    }

    public function setMessage(string $message): LoginDTOInterface
    {
        $this->setData(RequestInterface::MESSAGE_FIELD, $message);
        return $this;
    }

    public function setUser(UserModelInterface $user): LoginDTOInterface {
        $this->setData(LoginDTOInterface::USER_FIELD, $user);
        return $this;
    }
}