<?php

declare(strict_types=1);

return function ($container) {
    // SERVICES
    $container->add(
        \Romchik38\Server\Services\Session\Http\Session::class,
        new \Romchik38\Server\Services\Session\Http\Session()
    );

    $container->add(
        \Romchik38\Server\Api\Services\SessionInterface::class,
        $container->get(\Romchik38\Server\Services\Session\Http\Session::class)
    );

    $container->add(
        \Romchik38\Server\Services\Request\Http\UriFactory::class,
        new \Romchik38\Server\Services\Request\Http\UriFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Services\Request\Http\UriFactoryInterface::class,
        $container->get(\Romchik38\Server\Services\Request\Http\UriFactory::class)
    );

    // ROUTER
    $container->add(
        \Romchik38\Server\Results\Http\HttpRouterResult::class,
        new \Romchik38\Server\Results\Http\HttpRouterResult(
            /** default response, headers, statusCode */
        )
    );

    $container->add(
        \Romchik38\Server\Api\Results\Http\HttpRouterResultInterface::class,
        $container->get(\Romchik38\Server\Results\Http\HttpRouterResult::class)
    );

    // DTO
    $container->add(
        \Romchik38\Server\Models\DTO\RedirectResult\Http\RedirectResultDTOFactory::class,
        new \Romchik38\Server\Models\DTO\RedirectResult\Http\RedirectResultDTOFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\RedirectResult\Http\RedirectResultDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\RedirectResult\Http\RedirectResultDTOFactory::class)
    );

    return $container;
};
