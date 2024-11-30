<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\User;

use Romchik38\Server\Api\Models\RepositoryInterface;
use Romchik38\Site1\Domain\User\VO\Username;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getByUserName(Username $username): UserModelInterface;

    /** @throws NoSuchEntityException */
    public function getByEmail(string $email): UserModelInterface;
}
