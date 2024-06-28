<?php

namespace Romchik38\Site1\Api\Services;

interface UserRegisterInterface
{
    public function checkAvailableUsername(string $username): bool;
    public function checkUserInformation(): void;
    public function register(): void;
}
