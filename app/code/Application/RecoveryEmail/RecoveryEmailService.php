<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\RecoveryEmailService;

use Romchik38\Site1\Domain\RecoveryEmail\RecoveryEmailRepositoryInterface;

final class RecoveryEmailService
{
    public function __construct(
        protected RecoveryEmailRepositoryInterface $recoveryEmailRepository,
    ) {}
}
