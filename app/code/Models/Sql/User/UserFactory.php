<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\User;

use Romchik38\Server\Models\ModelFactory;
use Romchik38\Site1\Domain\User\UserFactoryInterface;
use Romchik38\Site1\Domain\User\UserModelInterface;

class UserFactory extends ModelFactory implements UserFactoryInterface {
    public function create(): UserModelInterface
    {
        return new User();
    }
}