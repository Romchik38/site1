<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\EntityRecoveryEmail;

final class CreateEmailTemplate
{
    public function __construct(
        public readonly string $email,
        public readonly string $firstname,
        public readonly string $hash
    ) {}
}
