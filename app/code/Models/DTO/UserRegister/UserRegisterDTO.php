<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\UserRegister;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\UserRegister\UserRegisterDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;

class UserRegisterDTO extends DTO implements UserRegisterDTOInterface {

    public function __construct(
        string $userName,
        string $password,
        string $firstName,
        string $lastName,
        string $email
    )
    {
        $this->data[RequestInterface::USERNAME_FIELD] = $userName;
        $this->data[RequestInterface::PASSWORD_FIELD] = $password;
        $this->data[RequestInterface::FIRST_NAME_FIELD] = $firstName;
        $this->data[RequestInterface::LAST_NAME_FIELD] = $lastName;
        $this->data[RequestInterface::EMAIL_FIELD] = $email;
    }

    public function getUserName(): string {
        return $this->data[RequestInterface::USERNAME_FIELD];
    }
    
    public function getPassword(): string {
        return $this->data[RequestInterface::PASSWORD_FIELD];
    }

    public function getFirstName(): string {
        return $this->data[RequestInterface::FIRST_NAME_FIELD];
    }

    public function getLastName(): string {
        return $this->data[RequestInterface::LAST_NAME_FIELD];
    }

    public function getEmail(): string {
        return $this->data[RequestInterface::EMAIL_FIELD];
    }

}