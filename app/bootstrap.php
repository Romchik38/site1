<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Routers\DefaultRouter;
use Romchik38\Server\Results\DefaultRouterResult;
use Romchik38\Server\Api\Server;
use Romchik38\Site1\Stubs\EchoLogger;

$container = new Container();

// ROUTER
$router = new DefaultRouter(
    new DefaultRouterResult(
        /** default response, headers, statusCode */
    )
);

$controllers = require_once(__DIR__ . '/code/Controllers/controllers.php');
foreach ($controllers as [$method, $url, $controller]) {
    $router->addController($method, $url, $controller);
}

$container->add(DefaultRouter::class, $router);

// SERVER
$container->add(Server::CONTAINER_LOGGER_FILED, new EchoLogger());

return $container;
