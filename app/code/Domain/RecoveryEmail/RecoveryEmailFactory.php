<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\RecoveryEmail;

use Romchik38\Site1\Domain\RecoveryEmail\RecoveryEmailInterface;

final class RecoveryEmailFactory
{
    public function create(): RecoveryEmailInterface
    {
        return new RecoveryEmail();
    }
}
