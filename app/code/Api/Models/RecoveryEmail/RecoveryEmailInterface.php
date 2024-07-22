<?php

declare(strict_types=1);

namespace Romchick38\Site1\Api\Models\RecoveryEmail;

use Romchik38\Server\Api\Models\ModelInterface;

interface RecoveryEmailInterface extends ModelInterface {
    const EMAIL_FIELD = 'email';
    const HASH_FIELD = 'hash';
    const UPDATED_AT_FIELD = 'updated_at';

    public function getEmail(): string;
    public function getHash(): string;
    public function getUpdatedAt(): string;

    public function setEmail(string $email): RecoveryEmailInterface;
    public function setHash(string $hash): RecoveryEmailInterface;
    public function setUpdatedAt(string $dateTime): RecoveryEmailInterface;
}