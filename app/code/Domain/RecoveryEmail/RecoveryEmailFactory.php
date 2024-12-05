<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\RecoveryEmail;

use Romchik38\Site1\Domain\RecoveryEmail\RecoveryEmailInterface;

final class RecoveryEmailFactory implements RecoveryEmailFactoryInterface
{
    public function create(): RecoveryEmailInterface
    {
        return new RecoveryEmail();
    }
}
