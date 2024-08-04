<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\User;

use Romchik38\Server\Api\Models\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface {
    public function create(array $row = null): UserModelInterface;
    public function getByUserName(string $userName): UserModelInterface;

    /** @throws NoSuchEntityException */
    public function getByEmail(string $email): UserModelInterface;
}