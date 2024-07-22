<?php

declare(strict_types=1);

namespace Romchick38\Site1\Api\Models\RecoveryEmail;

use Romchik38\Server\Api\Models\ModelFactoryInterface;
use Romchick38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface;

interface RecoveryEmailFactoryInterface extends ModelFactoryInterface {
    public function create(): RecoveryEmailInterface;
}