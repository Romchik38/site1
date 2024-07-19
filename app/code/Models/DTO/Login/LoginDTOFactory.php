<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Login;

use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use Romchik38\Site1\Models\DTO\Login\LoginDTO;
use Romchik38\Site1\Api\Models\User\UserModelInterface;

class LoginDTOFactory implements LoginDTOFactoryInterface {

    public function create(
        string $action,
        string $message,
        UserModelInterface|null $user
    ): LoginDTOInterface {
        return new LoginDTO($action, $message, $user);
    }
}