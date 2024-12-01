<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserRegister;

final class Register
{
    public const USERNAME_FIELD = 'user_name';
    public const PASSWORD_FIELD = 'password';
    public const FIRST_NAME_FIELD = 'first_name';
    public const LAST_NAME_FIELD = 'last_name';
    public const EMAIL_FIELD = 'email';

    protected function __construct(
        public readonly string $username,
        public readonly string $password,
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $email,
    ) {}

    public static function fromRequest(array $hash): self
    {
        return new self(
            $hash[self::USERNAME_FIELD] ?? '',
            $hash[self::PASSWORD_FIELD] ?? '',
            $hash[self::FIRST_NAME_FIELD] ?? '',
            $hash[self::LAST_NAME_FIELD] ?? '',
            $hash[self::EMAIL_FIELD] ?? ''
        );
    }
}
