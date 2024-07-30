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

    // ROUTER
    $container->add(
        \Romchik38\Server\Results\Http\HttpRouterResult::class,
        new \Romchik38\Server\Results\Http\HttpRouterResult(
            /** default response, headers, statusCode */
        )
    );

    return $container;
};
