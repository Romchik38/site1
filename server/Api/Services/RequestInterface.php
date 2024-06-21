<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services;

interface RequestInterface {
    const PASSWORD_FIELD = 'password';
    const USERNAME_FIELD = 'user_name';
    const MESSAGE_FIELD = 'message';

    public function getMessage(): string;
    public function getPassword(): string;
    public function getUserName(): string;
}