<?php

declare(strict_types=1);

use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;
use Romchik38\Server\Models\DTO\Email\EmailDTOFactory;
use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;

return function ($container) {
    // LOGGERS
    $configLogPrivate = require_once(__DIR__ . '/../config/private/logger.php');
    $configEmeilRecipient = $configLogPrivate['recipient'] ??
        throw new MissingRequiredParameterInFileError('Check config for logger email recipient');
    $configEmeilSender = $configLogPrivate['sender'] ??
        throw new MissingRequiredParameterInFileError('Check config for logger email sender');

    $configLogShared = require_once(__DIR__ . '/../config/shared/services/logger.php');
    $configLogLevelEmail = $configLogShared['log_level_email'] ??
        throw new MissingRequiredParameterInFileError('Check config for email log level');
    $configLogLevelFile = $configLogShared['log_level_file'] ??
        throw new MissingRequiredParameterInFileError('Check config for file log level');

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
    
    $configLogFilePath = $configLogShared['log_file_path'] ??
        throw new MissingRequiredParameterInFileError('Check config for logger file path');
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

    // USER RECOVERY EMAIL
    /** config data - we do not make a check here, because it's a shared config */
    $configRecoveryEmail = require_once(__DIR__ . '/../config/shared/services/user_recovery_email.php');        
    $container->add(
        \Romchik38\Site1\Services\UserRecoveryEmail::class,
        new \Romchik38\Site1\Services\UserRecoveryEmail(
            $container->get(\Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface::class),
            $configRecoveryEmail[UserRecoveryEmailInterface::ENTITY_ID_FIELD],
            $configRecoveryEmail[UserRecoveryEmailInterface::RECOVERY_EMAIL_FIELD],
            $configRecoveryEmail[UserRecoveryEmailInterface::RECOVERY_URL_DOMAIN_FIELD],
            $configRecoveryEmail[UserRecoveryEmailInterface::RECOVERY_URL_FIELD],
            $container->get(EmailDTOFactory::class),
            $container->get(\Romchik38\Server\Api\Services\MailerInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailRepositoryInterface::class),
            $container->get(\Psr\Log\LoggerInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site1\Api\Services\UserRecoveryEmailInterface::class,
        $container->get(\Romchik38\Site1\Services\UserRecoveryEmail::class)
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

    // Sitemap
    $container->add(
        \Romchik38\Server\Services\Sitemap\Sitemap::class,
        new \Romchik38\Server\Services\Sitemap\Sitemap(
            $container->get(Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOFactoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Server\Api\Services\SitemapInterface::class,
        $container->get(\Romchik38\Server\Services\Sitemap\Sitemap::class)
    );

    // GoogleReCaptcha
    $google_reCAPTCHA = require_once(__DIR__ . '/../config/private/google_reCAPTCHA.php');
    $container->add(
        \Romchik38\Site1\Services\Http\GoogleRecaptcha::class,
        new \Romchik38\Site1\Services\Http\GoogleRecaptcha(
            $container->get(\Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepositoryInterface::class),
            $google_reCAPTCHA,
            $container->get(\Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOFactoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Services\RequestInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site1\Api\Services\RecaptchaInterface::class,
        $container->get(\Romchik38\Site1\Services\Http\GoogleRecaptcha::class)
    );

    return $container;
};
