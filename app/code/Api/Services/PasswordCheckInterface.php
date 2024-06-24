<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Services;

interface PasswordCheckInterface
{
    public function checkCredentials(string $userName, string $password): int;
}