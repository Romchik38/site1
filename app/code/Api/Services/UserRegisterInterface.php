<?php

namespace Romchik38\Site1\Api\Services;

interface UserRegisterInterface
{
    public function checkAvailableUsername(): bool;
    public function checkUserInformation(): void;
    public function register(): void;
}
