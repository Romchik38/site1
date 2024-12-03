<?php

declare(strict_types=1);

use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;

return function ($container) {

    $configGoogleReCaptchas = require_once(__DIR__ . '/../config/shared/actions/google_recaptchas.php');

    // Root
    $container->add(
        \Romchik38\Site1\Controllers\Root\DefaultAction::class,
        new \Romchik38\Site1\Controllers\Root\DefaultAction(
            $container->get(\Romchik38\Site1\Api\Views\MainPageViewInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\Page\PageRepositoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site1\Controllers\Root\DynamicAction::class,
        new \Romchik38\Site1\Controllers\Root\DynamicAction(
            $container->get(\Romchik38\Site1\Api\Views\MainPageViewInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\Page\PageRepositoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface::class)
        )
    );

    // Login
    $container->add(
        \Romchik38\Site1\Controllers\Login\DefaultAction::class,
        new \Romchik38\Site1\Controllers\Login\DefaultAction(
            $container->get(\Romchik38\Site1\Api\Views\LoginPageViewInterface::class),
            $container->get(\Romchik38\Site1\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface::class),
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class)
        )
    );

    $configLoginDynamicGoogleReCaptchas = $configGoogleReCaptchas[\Romchik38\Site1\Controllers\Login\DynamicAction::class] ??
        throw new MissingRequiredParameterInFileError('Check config for action class: '
            . \Romchik38\Site1\Controllers\Login\DynamicAction::class);
    $container->add(
        \Romchik38\Site1\Controllers\Login\DynamicAction::class,
        new \Romchik38\Site1\Controllers\Login\DynamicAction(
            $container->get(\Romchik38\Site1\Api\Views\LoginPageViewInterface::class),
            $container->get(\Romchik38\Site1\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface::class),
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Services\RecaptchaInterface::class),
            $configLoginDynamicGoogleReCaptchas
        )
    );

    // Auth
    $configAuthDynamicGoogleReCaptchas = $configGoogleReCaptchas[\Romchik38\Site1\Controllers\Auth\DynamicAction::class] ??
        throw new MissingRequiredParameterInFileError('Check config for action class: '
            . \Romchik38\Site1\Controllers\Auth\DynamicAction::class);
    $container->add(
        \Romchik38\Site1\Controllers\Auth\DynamicAction::class,
        new \Romchik38\Site1\Controllers\Auth\DynamicAction(
            $container->get(\Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface::class),
            $container->get(\Romchik38\Site1\Application\UserPasswordCheck\UserPasswordCheckService::class),
            $container->get(\Romchik38\Site1\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site1\Application\UserRegister\UserRegisterService::class),
            $container->get(\Romchik38\Site1\Application\EntityRecoveryEmail\EntityRecoveryEmailService::class),
            $container->get(\Romchik38\Site1\Api\Services\RecaptchaInterface::class),
            $container->get(\Romchik38\Server\Api\Services\LoggerServerInterface::class),
            $container->get(\Romchik38\Site1\Application\UserChangePassword\UserChangePasswordService::class),
            $container->get(\Romchik38\Site1\Application\UserEmail\UserEmailService::class),
            $container->get(\Romchik38\Site1\Application\RecoveryEmail\RecoveryEmailService::class),
            $container->get(\Romchik38\Server\Api\Services\MailerInterface::class),
            $configAuthDynamicGoogleReCaptchas
        )
    );

    // Changepassword
    $container->add(
        \Romchik38\Site1\Controllers\Changepassword\DefaultAction::class,
        new \Romchik38\Site1\Controllers\Changepassword\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface::class),
            $container->get(\Romchik38\Site1\Application\RecoveryEmail\RecoveryEmailService::class),
            $container->get(\Romchik38\Site1\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class),
            $container->get(\Psr\Log\LoggerInterface::class),
            $container->get(\Romchik38\Site1\Application\UserEmail\UserEmailService::class)
        )
    );

    // Sitemap
    $container->add(
        Romchik38\Site1\Controllers\Sitemap\DefaultAction::class,
        new Romchik38\Site1\Controllers\Sitemap\DefaultAction(
            $container->get(\Romchik38\Site1\Api\Views\SitemapViewInterface::class),
            $container->get(\Romchik38\Site1\Controllers\Sitemap\SitemapLinkTreeInterface::class)
        )
    );

    // API
    // userinfo
    $container->add(
        \Romchik38\Site1\Controllers\Api\Userinfo\DefaultAction::class,
        new \Romchik38\Site1\Controllers\Api\Userinfo\DefaultAction(
            $container->get(\Romchik38\Site1\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\Api\ApiDTOFactoryInterface::class),
            $container->get(\Romchik38\Server\Views\JsonView::class)
        )
    );

    // Server Error
    $container->add(
        \Romchik38\Site1\Controllers\ServerError\DefaultAction::class,
        new \Romchik38\Site1\Controllers\ServerError\DefaultAction(
            $container->get(\Romchik38\Site1\Api\Views\DefaultPageViewInterface::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );

    // 404 Page not found
    $container->add(
        \Romchik38\Site1\Controllers\PageNotFound\DefaultAction::class,
        new \Romchik38\Site1\Controllers\PageNotFound\DefaultAction(
            $container->get('page-view-404'), // the name doesn't matter
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );

    return $container;
};
