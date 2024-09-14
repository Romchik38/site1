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
    UserRecoveryEmailInterface::ENTITY_ID_FIELD => 1,
    UserRecoveryEmailInterface::RECOVERY_EMAIL_FIELD => 'email_contact_recovery',
    UserRecoveryEmailInterface::RECOVERY_URL_DOMAIN_FIELD => 'url_domain',
    UserRecoveryEmailInterface::RECOVERY_URL_FIELD => 'url_recovery'
];