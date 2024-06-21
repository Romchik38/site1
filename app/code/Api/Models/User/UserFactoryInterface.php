<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\User;

use Romchik38\Server\Api\Models\ModelFactoryInterface;
use Romchik38\Site1\Api\Models\User\UserModelInterface;

interface UserFactoryInterface extends ModelFactoryInterface {
    public function create(): UserModelInterface;
}