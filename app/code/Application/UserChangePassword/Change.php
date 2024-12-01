<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserChangePassword;

final class Change
{
    public const PASSWORD_FIELD = 'password';

    protected function __construct(
        public readonly int $userId,
        public readonly string $password
        ) {}

    public static function fromRequest(int $id, array $hash): self
    {
        return new self(
            $id,
            $hash[self::PASSWORD_FIELD] ?? ''
        );
    }
}
