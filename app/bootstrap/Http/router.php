<?php

declare(strict_types=1);

return function ($container) {
    //$controllersList = require_once(__DIR__ . '/controllersList.php');
    $controllersFn = require_once(__DIR__ . '/actionsList.php');
    $controllersList = $controllersFn($container);

    // ROUTER HEADERS
    $headersFn = require_once(__DIR__ . '/router_headers.php');
    $headers = $headersFn($container);

    $container->add(
        \Romchik38\Server\Routers\Http\PlasticineRouter::class,
        new \Romchik38\Server\Routers\Http\PlasticineRouter(
            $container->get(\Romchik38\Server\Api\Results\Http\HttpRouterResultInterface::class),
            $controllersList,
            $container->get(\Romchik38\Server\Api\Services\Request\Http\RequestInterface::class),
            $headers,
            new \Romchik38\Server\Controllers\Controller(
                '404', 
                false,
                $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
                $container->get(Romchik38\Site1\Controllers\PageNotFound\DefaultAction::class)
            ), 
            $container->get(\Romchik38\Server\Api\Services\Redirect\Http\RedirectInterface::class)
        )
    );

    $container->add(
        \Romchik38\Server\Api\Router\RouterInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\PlasticineRouter::class)
    );

    return $container;
};
