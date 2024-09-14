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


    // REQUEST  depends only on this file or on no_dependencies global
    $container->add(
        \Romchik38\Server\Services\Request\Http\ServerRequestService::class,
        new \Romchik38\Server\Services\Request\Http\ServerRequestService()
    );
    $container->add(
        \Romchik38\Server\Api\Services\Request\Http\ServerRequestServiceInterface::class,
        $container->get(\Romchik38\Server\Services\Request\Http\ServerRequestService::class)
    );

    $container->add(
        \Romchik38\Site1\Services\Http\Request::class,
        new \Romchik38\Site1\Services\Http\Request(
            $container->get(\Romchik38\Server\Api\Services\Request\Http\UriFactoryInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Request\Http\ServerRequestServiceInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\UserRegister\UserRegisterDTOFactoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site1\Api\Services\RequestInterface::class,
        $container->get(\Romchik38\Site1\Services\Http\Request::class)
    );
    $container->add(
        \Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface::class,
        $container->get(\Romchik38\Site1\Api\Services\RequestInterface::class)
    );
    return $container;
};
