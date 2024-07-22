<?php

declare(strict_types=1);

namespace Romchick38\Site1\Models\Sql\RecoveryEmail;

use Romchick38\Site1\Api\Models\RecoveryEmail\RecoveryEmailFactoryInterface;
use Romchick38\Site1\Models\Sql\RecoveryEmail\RecoveryEmail;
use Romchick38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface;

class RecoveryEmailFactory implements RecoveryEmailFactoryInterface {
    public function create(): RecoveryEmailInterface {
        return new RecoveryEmail();
    }
}