<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserEmail\Views;

final class RecoveryDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $firstname
    ) {}
}
