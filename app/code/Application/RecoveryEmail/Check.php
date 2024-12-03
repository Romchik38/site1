<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\RecoveryEmail;

use Romchik38\Site1\Domain\RecoveryEmail\VO\Email;
use Romchik38\Site1\Domain\RecoveryEmail\VO\Hash;

final class Check
{
    public function __construct(
        public readonly string $email,
        public readonly string $hash
    ) {}

    public static function fromRequest(array $hash): self
    {
        return new self(
            $hash[Email::EMAIL_FIELD] ?? '',
            $hash[Hash::FIELD] ?? ''
        );
    }
}
