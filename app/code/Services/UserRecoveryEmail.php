<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services;

use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;

class UserRecoveryEmail implements UserRecoveryEmailInterface {
    public function sendRecoveryLink(string $email): void
    {
        
    }
}