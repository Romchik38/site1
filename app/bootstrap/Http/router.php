<?php

declare(strict_types=1);

return function ($container) {
    $controllersFn = require_once(__DIR__ . '/actionsList.php');
    $controllerCollection = $controllersFn($container);

    $container->add(
        \Romchik38\Server\Routers\Http\PlasticineRouter::class,
        new \Romchik38\Server\Routers\Http\PlasticineRouter(
            $container->get(\Romchik38\Server\Api\Results\Http\HttpRouterResultInterface::class),
            $controllerCollection,
            $container->get(\Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface::class),
            $container->get(Romchik38\Server\Api\Routers\Http\HeadersCollectionInterface::class),
            new \Romchik38\Server\Controllers\Controller(
                '404',      /** name doesn't matter */
                false,
                $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
                $container->get(Romchik38\Site1\Controllers\PageNotFound\DefaultAction::class)
            ), 
            $container->get(\Romchik38\Server\Api\Services\Redirect\Http\RedirectInterface::class)
        )
    );
    $container->add(
        \Romchik38\Server\Api\Routers\RouterInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\PlasticineRouter::class)
    );

    return $container;
};
