<?php

declare(strict_types=1);

return function ($container) {

    // USER RECOVERY EMAIL
    /** config data - we do not make a check here, because it's a shared config */
    $configRecoveryEmail = require_once(__DIR__ . '/../config/shared/services/user_recovery_email.php');
    $container->add(
        \Romchik38\Site1\Application\EntityRecoveryEmail\EntityRecoveryEmailService::class,
        new \Romchik38\Site1\Application\EntityRecoveryEmail\EntityRecoveryEmailService(
            $container->get(\Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface::class),
            $configRecoveryEmail['entityId'],
            $configRecoveryEmail['recovery_email'],
            $configRecoveryEmail['recovery_url_domain'],
            $configRecoveryEmail['recovery_url']
        )
    );

    // Recovery Email Service (hash)
    $container->add(
        \Romchik38\Site1\Application\RecoveryEmail\RecoveryEmailService::class,
        new \Romchik38\Site1\Application\RecoveryEmail\RecoveryEmailService(
            $container->get(\Romchik38\Site1\Domain\RecoveryEmail\RecoveryEmailRepositoryInterface::class),
            $container->get(\Psr\Log\LoggerInterface::class)
        )
    );

    // User Change Password
    $container->add(
        \Romchik38\Site1\Application\UserChangePassword\UserChangePasswordService::class,
        new \Romchik38\Site1\Application\UserChangePassword\UserChangePasswordService(
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class),
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

    // User Password Check
    $container->add(
        \Romchik38\Site1\Application\UserPasswordCheck\UserPasswordCheckService::class,
        new \Romchik38\Site1\Application\UserPasswordCheck\UserPasswordCheckService(
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class)
        )
    );

    // user Register
    $container->add(
        \Romchik38\Site1\Application\UserRegister\UserRegisterService::class,
        new \Romchik38\Site1\Application\UserRegister\UserRegisterService(
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class),
            $container->get(\Psr\Log\LoggerInterface::class)
        )
    );

    return $container;
};
