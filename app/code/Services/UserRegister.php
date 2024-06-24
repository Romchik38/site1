<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services;

use Romchik38\Site1\Api\Services\UserRegisterInterface;

class UserRegister implements UserRegisterInterface {

    public function __construct(
        
    )
    {
        
    }

    public function checkAvailableUsername(): bool
    {
        return false;
    }

    public function checkUserInformation(): void
    {
        
    }

    public function register(): void
    {
        
    }
}