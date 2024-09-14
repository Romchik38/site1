<?php

declare(strict_types=1);

use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;
use Romchik38\Server\Models\DTO\Email\EmailDTOFactory;
use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;

return function ($container) {
    // LOGGERS
    $configLog = require_once(__DIR__ . '/../config/private/logger.php');
    $configEmeilRecipient = $configLog['recipient'] ??
        throw new MissingRequiredParameterInFileError('Check config for logger email recipient');
    $configEmeilSender = $configLog['sender'] ??
        throw new MissingRequiredParameterInFileError('Check config for logger email sender');

    $container->add(
        \Romchik38\Server\Services\Logger\Loggers\EmailLogger::class,
        new \Romchik38\Server\Services\Logger\Loggers\EmailLogger(
            4,
            $container->get(\Romchik38\Server\Api\Services\MailerInterface::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\Email\EmailDTOFactoryInterface::class),
            $configEmeilRecipient,
            $configEmeilSender,
            null
        )
    );
    
    $configLogFilePath = $configLog['log_file_path'] ??
        throw new MissingRequiredParameterInFileError('Check config for logger file path');
    $container->add(
        \Romchik38\Server\Services\Logger\Loggers\FileLogger::class,
        new \Romchik38\Server\Services\Logger\Loggers\FileLogger(
            __DIR__ . $configLogFilePath,
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
    /** config data - we do not make a check here, because it's a shared config */
    $configRecoveryEmail = require_once(__DIR__ . '/../config/shared/services/user_recovery_email.php');
    $configRecoveryEmailEntity = $configRecoveryEmail[UserRecoveryEmailInterface::ENTITY_ID_FIELD];
    $configRecoveryEmailSender = $configRecoveryEmail[UserRecoveryEmailInterface::RECOVERY_EMAIL_FIELD]; 
    $configRecoveryEmailDomain = $configRecoveryEmail[UserRecoveryEmailInterface::RECOVERY_URL_DOMAIN_FIELD];
    $configRecoveryEmailUrl = $configRecoveryEmail[UserRecoveryEmailInterface::RECOVERY_URL_FIELD];          
    $container->add(
        \Romchik38\Site1\Services\UserRecoveryEmail::class,
        new \Romchik38\Site1\Services\UserRecoveryEmail(
            $container->get(\Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface::class),
            $configRecoveryEmailEntity,
            $configRecoveryEmailSender,
            $configRecoveryEmailDomain,
            $configRecoveryEmailUrl,
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
