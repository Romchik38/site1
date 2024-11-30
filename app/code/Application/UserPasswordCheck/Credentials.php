<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserPasswordCheck;

final class Credentials
{
    public const PASSWORD_FIELD = 'password';
    public const USERNAME_FIELD = 'user_name';

    protected function __construct(
        public readonly string $password,
        public readonly string $username
    ) {}

    public static function fromRequest(array $hash): self
    {
        return new self(
            $hash[self::PASSWORD_FIELD] ?? '',
            $hash[self::USERNAME_FIELD] ?? ''
        );
    }
}
