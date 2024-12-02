<?php

declare(strict_types=1);

use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;
use Romchik38\Server\Models\DTO\Email\EmailDTOFactory;
use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;

return function ($container) {

    // PASSWORDCHECK
    $container->add(
        \Romchik38\Site1\Application\UserPasswordCheck\UserPasswordCheckService::class,
        new \Romchik38\Site1\Application\UserPasswordCheck\UserPasswordCheckService(
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class)
        )
    );


    // USERREGISTER
    $container->add(
        \Romchik38\Site1\Application\UserRegister\UserRegisterService::class,
        new \Romchik38\Site1\Application\UserRegister\UserRegisterService(
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class),
            $container->get(\Psr\Log\LoggerInterface::class)
        )
    );

    // USER RECOVERY EMAIL
    /** config data - we do not make a check here, because it's a shared config */
    $configRecoveryEmail = require_once(__DIR__ . '/../config/shared/services/user_recovery_email.php');
    $container->add(
        \Romchik38\Site1\Application\UserRecoveryEmail\UserRecoveryEmailService::class,
        new \Romchik38\Site1\Application\UserRecoveryEmail\UserRecoveryEmailService(
            $container->get(\Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface::class),
            $configRecoveryEmail['entityId'],
            $configRecoveryEmail['recovery_email'],
            $configRecoveryEmail['recovery_url_domain'],
            $configRecoveryEmail['recovery_url'],
            $container->get(EmailDTOFactory::class),
            $container->get(\Romchik38\Server\Api\Services\MailerInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailRepositoryInterface::class),
            $container->get(\Psr\Log\LoggerInterface::class)
        )
    );

    // User Email Service
    $container->add(
        \Romchik38\Site1\Application\UserEmail\UserEmailService::class,
        new \Romchik38\Site1\Application\UserEmail\UserEmailService(
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class)
        )
    );

    return $container;
};
