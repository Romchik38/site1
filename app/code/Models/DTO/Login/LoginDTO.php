<?php

namespace Romchik38\Site1\Models\DTO\Login;

use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Models\User\UserModelInterface;

class LoginDTO extends DTO implements LoginDTOInterface
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
        $this->data[RequestInterface::MESSAGE_FIELD] = $message;
        $this->data[LoginDTOInterface::USER_FIELD] = $user;
        $this->data[DefaultViewDTOInterface::DEFAULT_NAME_FIELD] = $name;
        $this->data[DefaultViewDTOInterface::DEFAULT_DESCRIPTION_FIELD] = $description;
        $this->data[LoginDTOInterface::RECAPTCHA_HASH_FIELD] = $recaptchaHash;
    }

    public function getActionName(): string
    {
        return $this->getData($this::ACTION_FIELD_NAME);
    }

    public function getContent(): string
    {
        return $this->getData(DefaultViewDTOInterface::DEFAULT_CONTENT_FIELD);
    }

    public function getDescription(): string
    {
        return $this->getData(DefaultViewDTOInterface::DEFAULT_DESCRIPTION_FIELD);
    }

    public function getMessage(): string
    {
        return $this->getData(RequestInterface::MESSAGE_FIELD);
    }

    public function getName(): string
    {
        return $this->getData(DefaultViewDTOInterface::DEFAULT_NAME_FIELD);
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
