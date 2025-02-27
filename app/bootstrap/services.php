<?php

declare(strict_types=1);

return function ($container) {
    // LOGGERS
    $configLogPrivate = require_once(__DIR__ . '/../config/private/logger.php');
    $configEmeilRecipient = $configLogPrivate['recipient'] ??
        throw new RuntimeException('Check config for logger email recipient');
    $configEmeilSender = $configLogPrivate['sender'] ??
        throw new RuntimeException('Check config for logger email sender');

    $configLogShared = require_once(__DIR__ . '/../config/shared/services/logger.php');
    $configLogLevelEmail = $configLogShared['log_level_email'] ??
        throw new RuntimeException('Check config for email log level');
    $configLogLevelFile = $configLogShared['log_level_file'] ??
        throw new RuntimeException('Check config for file log level');

    // EMAIL
    $container->add(
        \Romchik38\Server\Services\Logger\Loggers\EmailLogger::class,
        new \Romchik38\Server\Services\Logger\Loggers\EmailLogger(
            $configLogLevelEmail,
            $container->get(\Romchik38\Server\Api\Services\MailerInterface::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\Email\EmailDTOFactoryInterface::class),
            $configEmeilRecipient,
            $configEmeilSender,
            null
        )
    );
    // FILE
    $configLogFilePath = $configLogShared['log_file_path'] ??
        throw new RuntimeException('Check config for logger file path');
    $container->add(
        \Romchik38\Server\Services\Logger\Loggers\FileLogger::class,
        new \Romchik38\Server\Services\Logger\Loggers\FileLogger(
            __DIR__ . $configLogFilePath,
            $configLogLevelFile,
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

    // STATIC MENU       
    $container->add(
        \Romchik38\Site1\Services\Menu\StaticMenuService::class,
        new \Romchik38\Site1\Services\Menu\StaticMenuService(
            $container->get(\Romchik38\Site1\Api\Models\Menu\MenuModelRepositoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkRepositoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Menu\LinkDTOFactoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOFactoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site1\Api\Services\Menu\StaticMenuServiceInterface::class,
        $container->get(\Romchik38\Site1\Services\Menu\StaticMenuService::class)
    );

    // ControllerTree
    $container->add(
        \Romchik38\Server\Services\Mappers\ControllerTree\ControllerTree::class,
        new \Romchik38\Server\Services\Mappers\ControllerTree\ControllerTree
    );
    $container->add(
        \Romchik38\Server\Api\Services\Mappers\ControllerTreeInterface::class,
        $container->get(\Romchik38\Server\Services\Mappers\ControllerTree\ControllerTree::class)
    );

    // GoogleReCaptcha
    $google_reCAPTCHA = require_once(__DIR__ . '/../config/private/google_reCAPTCHA.php');
    $container->add(
        \Romchik38\Site1\Services\Http\GoogleRecaptcha::class,
        new \Romchik38\Site1\Services\Http\GoogleRecaptcha(
            $container->get(\Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepositoryInterface::class),
            $google_reCAPTCHA,
            $container->get(\Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOFactoryInterface::class),
            $container->get(\Psr\Http\Message\ServerRequestInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site1\Api\Services\RecaptchaInterface::class,
        $container->get(\Romchik38\Site1\Services\Http\GoogleRecaptcha::class)
    );
    
    // Breadcumb
    $container->add(
        \Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb::class,
        new \Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb(
            $container->get(\Romchik38\Server\Api\Services\Mappers\ControllerTreeInterface::class)            
        )
    );
    $container->add(
        \Romchik38\Server\Api\Services\Mappers\Breadcrumb\Http\BreadcrumbInterface::class,
        $container->get(\Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb::class)
    );

    // LinkTree
    $container->add(
        \Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree::class,
        new \Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree
    );
    $container->add(
        \Romchik38\Server\Api\Services\Mappers\LinkTree\Http\LinkTreeInterface::class,
        $container->get(\Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree::class)

    );

    return $container;
};
