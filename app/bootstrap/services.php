<?php

declare(strict_types=1);

use Romchik38\Server\Models\DTO\Email\EmailDTOFactory;

return function ($container) {

    $container->add(
        \Romchik38\Server\Services\Logger\Loggers\EmailLogger::class,
        new \Romchik38\Server\Services\Logger\Loggers\EmailLogger(
            4,
            $container->get(\Romchik38\Server\Services\Mailer\PhpMail::class),
            $container->get(\Romchik38\Server\Models\DTO\Email\EmailDTOFactory::class),
            'pomahehko.c@gmail.com',
            'ser@ozone.com.ua',
            null
        )
    );

    $container->add(
        \Romchik38\Server\Api\Services\LoggerServerInterface::class,
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
        \Psr\Log\LoggerInterface::class,
        $container->get(\Romchik38\Server\Api\Services\LoggerServerInterface::class)
    );

    $container->add(
        \Romchik38\Site1\Services\Http\Request::class,
        new \Romchik38\Site1\Services\Http\Request(
            $container->get(\Romchik38\Site1\Models\DTO\UserRegisterDTOFactory::class)
        )
    );

    $container->add(
        \Romchik38\Site1\Services\PasswordCheck::class,
        new \Romchik38\Site1\Services\PasswordCheck(
            $container->get(\Romchik38\Site1\Api\Models\User\UserRepositoryInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site1\Services\UserRegister::class,
        new \Romchik38\Site1\Services\UserRegister(
            $container->get(\Romchik38\Site1\Api\Models\User\UserRepositoryInterface::class),
            $container->get(\Psr\Log\LoggerInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site1\Services\UserRecoveryEmail::class,
        new \Romchik38\Site1\Services\UserRecoveryEmail(
            $container->get(\Romchik38\Server\Models\Sql\Entity\EntityRepository::class),
            1,
            'email_contact_recovery',
            'url_domain',
            'url_recovery',
            $container->get(EmailDTOFactory::class),
            $container->get(\Romchik38\Server\Services\Mailer\PhpMail::class),
            $container->get(\Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailRepository::class),
            $container->get(\Psr\Log\LoggerInterface::class)
        )
    );

    $container->add(
        \Romchik38\Server\Services\Redirect::class,
        function ($container) {
            return new \Romchik38\Server\Services\Redirect(
                $container->get(\Romchik38\Site1\Models\Sql\Redirect\RedirectRepository::class)
            );
        }
    );

    return $container;
};
