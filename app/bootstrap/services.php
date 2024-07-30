<?php

declare(strict_types=1);

use Romchik38\Server\Models\DTO\Email\EmailDTOFactory;

return function ($container) {
    // LOGGERS
    $container->add(
        \Romchik38\Server\Services\Logger\Loggers\EmailLogger::class,
        new \Romchik38\Server\Services\Logger\Loggers\EmailLogger(
            4,
            $container->get(\Romchik38\Server\Api\Services\MailerInterface::class),
            $container->get(\Romchik38\Server\Models\DTO\Email\EmailDTOFactory::class),
            'pomahehko.c@gmail.com',
            'ser@ozone.com.ua',
            null
        )
    );
    $container->add(
        \Romchik38\Server\Services\Logger\Loggers\FileLogger::class,
        new \Romchik38\Server\Services\Logger\Loggers\FileLogger(
            __DIR__ . '/../var/default.log',
            7,
            \Romchik38\Server\Api\Services\Loggers\FileLoggerInterface::DEFAULT_PROTOCOL,
            false,
            null,
            $container->get(\Romchik38\Server\Services\Logger\Loggers\EmailLogger::class)
        )
    );

    $container->add(
        \Romchik38\Server\Api\Services\LoggerServerInterface::class,
        $container->get(\Romchik38\Server\Services\Logger\Loggers\FileLogger::class)
    );

    $container->add(
        \Psr\Log\LoggerInterface::class,
        $container->get(\Romchik38\Server\Api\Services\LoggerServerInterface::class)
    );

    // PASSWORDCHECK
    $container->add(
        \Romchik38\Site1\Services\PasswordCheck::class,
        new \Romchik38\Site1\Services\PasswordCheck(
            $container->get(\Romchik38\Site1\Api\Models\User\UserRepositoryInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site1\Api\Services\PasswordCheckInterface::class,
        $container->get(\Romchik38\Site1\Services\PasswordCheck::class)
    );

    // USERREGISTER
    $container->add(
        \Romchik38\Site1\Services\UserRegister::class,
        new \Romchik38\Site1\Services\UserRegister(
            $container->get(\Romchik38\Site1\Api\Models\User\UserRepositoryInterface::class),
            $container->get(\Psr\Log\LoggerInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site1\Api\Services\UserRegisterInterface::class,
        $container->get(\Romchik38\Site1\Services\UserRegister::class)
    );

    // USERRECOVERYEMAIL
    $container->add(
        \Romchik38\Site1\Services\UserRecoveryEmail::class,
        new \Romchik38\Site1\Services\UserRecoveryEmail(
            $container->get(\Romchik38\Server\Models\Sql\Entity\EntityRepository::class),
            1,
            'email_contact_recovery',
            'url_domain',
            'url_recovery',
            $container->get(EmailDTOFactory::class),
            $container->get(\Romchik38\Server\Api\Services\MailerInterface::class),
            $container->get(\Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailRepository::class),
            $container->get(\Psr\Log\LoggerInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site1\Api\Services\UserRecoveryEmailInterface::class,
        $container->get(\Romchik38\Site1\Services\UserRecoveryEmail::class)
    );

    return $container;
};
