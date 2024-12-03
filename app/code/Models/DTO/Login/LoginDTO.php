<?php

namespace Romchik38\Site1\Models\DTO\Login;

use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site1\Controllers\Login\Message;
use Romchik38\Site1\Domain\User\UserModelInterface;

class LoginDTO extends DefaultViewDTO implements LoginDTOInterface
{

    public function __construct(
        string $action,
        string $message,
        UserModelInterface|null $user,
        string $name,
        string $description,
        array $recaptchaHash
    ) {
        $this->data[$this::ACTION_FIELD_NAME] = $action;
        $this->data[Message::FIELD] = $message;
        $this->data[LoginDTOInterface::USER_FIELD] = $user;
        $this->data[DefaultViewDTOInterface::DEFAULT_NAME_FIELD] = $name;
        $this->data[DefaultViewDTOInterface::DEFAULT_DESCRIPTION_FIELD] = $description;
        $this->data[LoginDTOInterface::RECAPTCHA_HASH_FIELD] = $recaptchaHash;
    }

    public function getActionName(): string
    {
        return $this->getData($this::ACTION_FIELD_NAME);
    }
    public function getMessage(): string
    {
        return $this->getData(Message::FIELD);
    }

    public function getUser(): UserModelInterface|null
    {
        return $this->getData(LoginDTOInterface::USER_FIELD);
    }

    public function getRecaptchaHash(): array
    {
        return $this->data[LoginDTOInterface::RECAPTCHA_HASH_FIELD];
    }
}
