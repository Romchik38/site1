<?php

declare(strict_types=1);

use Laminas\Diactoros\ResponseFactory;
use Romchik38\Server\Api\Routers\Http\HttpRouterInterface;

return function ($container) {
    $controllersFn = require_once(__DIR__ . '/actionsList.php');
    $controllerCollection = $controllersFn($container);

    $container->add(
        \Romchik38\Server\Routers\Http\PlasticineRouter::class,
        new \Romchik38\Server\Routers\Http\PlasticineRouter(
            new ResponseFactory,
            $controllerCollection,
            $container->get(\Psr\Http\Message\ServerRequestInterface::class),
            new \Romchik38\Server\Controllers\Controller(
                HttpRouterInterface::NOT_FOUND_CONTROLLER_NAME,
                false,
                $container->get(Romchik38\Site1\Controllers\PageNotFound\DefaultAction::class)
            ), 
            $container->get(\Romchik38\Server\Api\Services\Redirect\Http\RedirectInterface::class)
        )
    );
    $container->add(
        \Romchik38\Server\Api\Routers\Http\HttpRouterInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\PlasticineRouter::class)
    );

    return $container;
};
