<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\RecoveryEmail;

use Romchik38\Server\Api\Models\ModelFactoryInterface;
use Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface;

interface RecoveryEmailFactoryInterface extends ModelFactoryInterface {
    public function create(): RecoveryEmailInterface;
}