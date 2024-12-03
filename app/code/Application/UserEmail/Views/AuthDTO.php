<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserEmail\Views;

final class AuthDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
    ) {}
}