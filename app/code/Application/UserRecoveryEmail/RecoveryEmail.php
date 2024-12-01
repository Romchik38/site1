<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserRecoveryEmail;

final class RecoveryEmail
{
    public const EMAIL_FIELD = 'email';

    protected function __construct(
        public readonly string $email
    ) {}

    public static function fromRequest(array $hash): self
    {
        return new self(
            $hash[self::EMAIL_FIELD] ?? '',
        );
    }
}
