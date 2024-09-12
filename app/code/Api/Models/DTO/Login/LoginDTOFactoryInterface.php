<?php

namespace Romchik38\Site1\Api\Models\DTO\Login;

use Romchik38\Site1\Api\Models\User\UserModelInterface;

interface LoginDTOFactoryInterface {
    public function create(
        string $action,
        string $message,
        UserModelInterface|null $user,
        string $name,
        string $description,
        array $recaptchaHash = []
    );
}