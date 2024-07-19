<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO;

use Romchik38\Site1\Api\Models\DTO\UserRegisterDTOInterface;

interface UserRegisterDTOFactoryInterface {
    public function create(
        string $userName,
        string $password,
        string $firstName,
        string $lastName,
        string $email
    ): UserRegisterDTOInterface;
}