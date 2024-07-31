<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\UserRegister;

use Romchik38\Site1\Api\Models\DTO\UserRegister\UserRegisterDTOInterface;

interface UserRegisterDTOFactoryInterface {
    public function create(
        string $userName,
        string $password,
        string $firstName,
        string $lastName,
        string $email
    ): UserRegisterDTOInterface;
}