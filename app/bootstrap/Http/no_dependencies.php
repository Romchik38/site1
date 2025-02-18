<?php

declare(strict_types=1);

return function ($container) {
    
    // SERVICES
    $container->add(
        \Romchik38\Site1\Services\Http\Session::class,
        new Romchik38\Site1\Services\Http\Session()
    );

    $container->add(
        \Romchik38\Site1\Api\Services\SessionInterface::class,
        $container->get(\Romchik38\Site1\Services\Http\Session::class)
    );
    $container->add(
        \Romchik38\Server\Api\Services\SessionInterface::class,
        $container->get(\Romchik38\Site1\Services\Http\Session::class)
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
        Laminas\Diactoros\ServerRequest::class,
        Laminas\Diactoros\ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        )
    );
    $container->add(
        Psr\Http\Message\ServerRequestInterface::class,
        $container->get(Laminas\Diactoros\ServerRequest::class)
    );
    return $container;
};
