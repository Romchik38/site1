<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\UserRegister;

use Romchik38\Site1\Api\Models\DTO\UserRegister\UserRegisterDTOFactoryInterface;

class UserRegisterDTOFactory implements UserRegisterDTOFactoryInterface {

    public function create(
        string $userName,
        string $password,
        string $firstName,
        string $lastName,
        string $email
    ): UserRegisterDTO
    {
        return new UserRegisterDTO(
            $userName,
            $password,
            $firstName,
            $lastName,
            $email
        );
    }
}