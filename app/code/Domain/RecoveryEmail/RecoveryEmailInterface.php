<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\RecoveryEmail;

use Romchik38\Server\Api\Models\ModelInterface;

interface RecoveryEmailInterface extends ModelInterface {
    const EMAIL_FIELD = 'email';
    const HASH_FIELD = 'hash';
    const UPDATED_AT_FIELD = 'updated_at';
    const DATE_TIME_FORMAT = 'Y-m-d H:i:s';
    const VALID_TIME = 1800; // 30 min

    public function getEmail(): string;
    public function getHash(): string;
    public function getUpdatedAt(): string;

    public function setEmail(string $email): RecoveryEmailInterface;
    public function setHash(string $hash): RecoveryEmailInterface;
    public function setUpdatedAt(string $hash = ''): RecoveryEmailInterface;

}