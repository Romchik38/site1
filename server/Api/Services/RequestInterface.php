<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services;

interface RequestInterface {
    const PASSWORD_FIELD = 'password';
    const USERNAME_FIELD = 'user_name';

    public function getUserName(): string;
    public function getPassword(): string;
}