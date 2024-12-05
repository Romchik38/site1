<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\RecoveryEmail;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

interface RecoveryEmailFactoryInterface extends ModelFactoryInterface
{
    public function create(): RecoveryEmailInterface;
}
