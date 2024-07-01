<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Services;

use Romchik38\Site1\Api\Models\DTO\RegisterDTOInterface;

interface RequestInterface {

    const EMAIL_FIELD = 'email';
    const EMAIL_PATTERN = '^[A-Za-z0-9.]{2,}@[A-Za-z0-9.]{2,}\.[a-z]{2,}$';
    const EMAIL_ERROR_MESSAGE = 'Email Local Part can contain latin characters and a dot. Domain can contain latin characters and a dot, must end minimun with 2 characters after a dot';

    const FIRST_NAME_FIELD = 'first_name';
    const FIRST_NAME_PATTERN = '^[\p{L}]{3,30}$';
    const FIRST_NAME_ERROR_MESSAGE = 'First name must be 3-30 characters long, can contain letters';

    const LAST_NAME_FIELD = 'last_name';
    const LAST_NAME_PATTERN = '^[\p{L}]{3,30}$';
    const LAST_NAME_ERROR_MESSAGE = 'Last name must be 3-30 characters long, can contain letters';

    const MESSAGE_FIELD = 'message';

    const PASSWORD_FIELD = 'password';
    const PASSWORD_PATTERN = '^(?=.*[_`$%^*\'])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9_`$%^*\']{8,}$';
    const PASSWORD_ERROR_MESSAGE = 'Password must be at least 8 characters long, contain at least one lowercase, uppercase letter, number and a specal character from _`$%^*\'';

    const USERNAME_FIELD = 'user_name';    
    const USERNAME_PATTERN = '[A-Za-z0-9_]{3,20}$';
    const USERNAME_ERROR_MESSAGE = 'Username must be 3-20 characters long, can contain lowercase, uppercase letter, number and underscore. Case-Sensitive';

    public function getEmail(): string;
    public function getMessage(): string;
    public function getPassword(): string;
    public function getUserName(): string;
    public function getUserRegisterData(): RegisterDTOInterface;
}