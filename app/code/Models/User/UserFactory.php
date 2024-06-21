<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\User;

use Romchik38\Site1\Models\User\User;
use Romchik38\Site1\Api\Models\User\UserFactoryInterface;
use Romchik38\Site1\Api\Models\User\UserModelInterface;
use Romchik38\Server\Models\ModelFactory;


class UserFactory extends ModelFactory implements UserFactoryInterface {
    public function create(): UserModelInterface
    {
        return new User();
    }
}