<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services;

interface RequestInterface {
    const FIRST_NAME_FIELD = 'first_name';
    const LAST_NAME_FIELD = 'last_name';
    const PASSWORD_FIELD = 'password';
    const USERNAME_FIELD = 'user_name';
    const MESSAGE_FIELD = 'message';

    public function getMessage(): string;
    public function getPassword(): string;
    public function getUserName(): string;
}