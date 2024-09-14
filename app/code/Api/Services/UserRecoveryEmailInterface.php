<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Services;

interface UserRecoveryEmailInterface {

    const ENTITY_ID_FIELD = 'entityId';
    const RECOVERY_EMAIL_FIELD = 'recovery_email';
    const RECOVERY_URL_DOMAIN_FIELD = 'recovery_url_domain';
    const RECOVERY_URL_FIELD = 'recovery_url';

    public function checkHash(string $email, string $hash): bool;
    public function sendRecoveryLink(string $email): void;
}