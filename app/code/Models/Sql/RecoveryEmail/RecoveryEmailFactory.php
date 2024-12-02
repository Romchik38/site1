<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\RecoveryEmail;

use Romchik38\Site1\Domain\RecoveryEmail\RecoveryEmailFactoryInterface;
use Romchik38\Site1\Domain\RecoveryEmail\RecoveryEmailInterface;

class RecoveryEmailFactory implements RecoveryEmailFactoryInterface {
    public function create(): RecoveryEmailInterface {
        return new RecoveryEmail();
    }
}