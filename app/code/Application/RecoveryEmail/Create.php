<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\RecoveryEmailService;

final class Create
{
    public function __construct(
        public readonly string $email
    ) {}
}
