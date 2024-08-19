<?php

declare(strict_types=1);

return function ($container) {

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
            $container->get(\Romchik38\Server\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Services\RequestInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\User\UserRepositoryInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site1\Controllers\Login\DynamicAction::class,
        new \Romchik38\Site1\Controllers\Login\DynamicAction(
            $container->get(\Romchik38\Site1\Api\Views\LoginPageViewInterface::class),
            $container->get(\Romchik38\Server\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Services\RequestInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\User\UserRepositoryInterface::class)
        )
    );

    // Auth
    $container->add(
        \Romchik38\Site1\Controllers\Auth\DynamicAction::class,
        new \Romchik38\Site1\Controllers\Auth\DynamicAction(
            $container->get(\Romchik38\Site1\Api\Services\RequestInterface::class),
            $container->get(\Romchik38\Site1\Api\Services\PasswordCheckInterface::class),
            $container->get(\Romchik38\Server\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site1\Api\Services\UserRegisterInterface::class),
            $container->get(\Romchik38\Site1\Api\Services\UserRecoveryEmailInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\User\UserRepositoryInterface::class)
        )
    );

    // Stub
    $container->add(
        \Romchik38\Site1\Controllers\DefaultActionStub::class,
        new \Romchik38\Site1\Controllers\DefaultActionStub()
    );

    return $container;
};