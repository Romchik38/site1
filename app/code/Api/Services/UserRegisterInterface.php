<?php

namespace Romchik38\Site1\Api\Services;

use Romchik38\Site1\Api\Models\DTO\RegisterDTOInterface;

interface UserRegisterInterface
{
    public function checkAvailableUsername(string $username): bool;
    public function checkUserInformation(RegisterDTOInterface $userRegisterDTO): void;
    public function register(): void;
}
