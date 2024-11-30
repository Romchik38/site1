<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\User;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

interface UserFactoryInterface extends ModelFactoryInterface {
    public function create(): UserModelInterface;
}