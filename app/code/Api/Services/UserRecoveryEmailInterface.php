<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Services;

interface UserRecoveryEmailInterface {
    public function checkHash(string $hash): bool;
    public function sendRecoveryLink(string $email): void;
}