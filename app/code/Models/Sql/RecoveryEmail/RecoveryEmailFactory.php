<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\RecoveryEmail;

use Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailFactoryInterface;
use Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmail;
use Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface;

class RecoveryEmailFactory implements RecoveryEmailFactoryInterface {
    public function create(): RecoveryEmailInterface {
        return new RecoveryEmail();
    }
}