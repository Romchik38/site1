<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\RecoveryEmail;

final class Check
{
    public function __construct(
        public readonly string $email,
        public readonly string $hash
    ) {}
}
