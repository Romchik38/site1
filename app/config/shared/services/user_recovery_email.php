<?php

declare(strict_types=1);

use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;

return [
    /** 
     * Config data for a recovery email service
     * 
     * config_name => database value 
     * see entity.sql file for postgresql database
     */
    'entityId' => 1,
    'recovery_email' => 'email_contact_recovery',
    'recovery_url_domain' => 'url_domain',
    'recovery_url' => 'url_recovery'
];
