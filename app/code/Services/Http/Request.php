<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Http;

use Romchik38\Site1\Api\Models\DTO\UserRegisterDTOInterface;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Models\DTO\UserRegisterDTOFactoryInterface;

class Request implements RequestInterface {

    public function __construct(
        protected UserRegisterDTOFactoryInterface $userRegisterDTOFactory
    ) {  
    }

    public function getEmail(): string
    {
        return $_POST[RequestInterface::EMAIL_FIELD] ?? '';
    }

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

    /**
     * Returns DTO with register data for next checks
     *
     * @return UserRegisterDTOInterface
     */
    public function getUserRegisterData(): UserRegisterDTOInterface
    {
        return $this->userRegisterDTOFactory->create(
            $_POST[$this::USERNAME_FIELD] ?? '',
            $_POST[$this::PASSWORD_FIELD] ?? '',
            $_POST[$this::FIRST_NAME_FIELD] ?? '',
            $_POST[$this::LAST_NAME_FIELD] ?? '',
            $_POST[$this::EMAIL_FIELD] ?? ''
        );
    }

    /**
     * Returns username or ''
     *
     * @return string
     */
    public function getUserName(): string
    {
        return $_POST[RequestInterface::USERNAME_FIELD] ?? '';
    }
}