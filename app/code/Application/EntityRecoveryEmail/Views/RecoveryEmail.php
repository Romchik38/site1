<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserRecoveryEmail\Views;

final class RecoveryEmail
{
    public function __construct(
        public readonly string $subject,
        public readonly string $message,
        public readonly array $headers
    ) {}
}
