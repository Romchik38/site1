<?php

namespace Romchik38\Site1\Api\Services;

use Romchik38\Site1\Api\Models\DTO\UserRegisterDTOInterface;
use Romchik38\Site1\Api\Models\User\UserModelInterface;

interface UserRegisterInterface
{
    public function checkAvailableUsername(string $username): bool;
    public function checkPasswordChange(string $password): void;
    public function checkUserInformation(UserRegisterDTOInterface $userRegisterDTO): void;
    public function changePassword(int $userId, string $password): bool;
    public function register(UserRegisterDTOInterface $userRegisterDTO): UserModelInterface;
}
