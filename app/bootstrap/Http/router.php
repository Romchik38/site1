<?php

declare(strict_types=1);

return function ($container) {
    //$controllersList = require_once(__DIR__ . '/controllersList.php');
    $controllersFn = require_once(__DIR__ . '/actionsList.php');
    $controllersList = $controllersFn($container);
    // $container->add(
    //     \Romchik38\Server\Routers\Http\DefaultRouter::class,
    //     new \Romchik38\Server\Routers\Http\DefaultRouter(
    //         $container->get(\Romchik38\Server\Api\Results\Http\HttpRouterResultInterface::class),
    //         $controllersList,
    //         $container,
    //         null,
    //         $container->get(\Romchik38\Server\Api\Services\RedirectInterface::class)
    //     )
    // );

    $container->add(
        \Romchik38\Server\Routers\Http\PlasticineRouter::class,
        new \Romchik38\Server\Routers\Http\PlasticineRouter(
            $container->get(\Romchik38\Server\Api\Results\Http\HttpRouterResultInterface::class),
            $controllersList,
            [],
            null,
            null
        )
    );

    $container->add(
        \Romchik38\Server\Api\Router\RouterInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\PlasticineRouter::class)
    );

    return $container;
};
