<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Routers\DefaultRouter;
use Romchik38\Server\Results\DefaultRouterResult;
use Romchik38\Server\Api\Server;
use Romchik38\Site1\Stubs\EchoLogger;

$container = new Container();

// ROUTER
$container->add(DefaultRouterResult::class, new DefaultRouterResult(
    /** default response, headers, statusCode */
));

$controllers = require_once(__DIR__ . '/code/Controllers/controllersList.php');

$container->add(
    DefaultRouter::class, new DefaultRouter(
            $container->get(DefaultRouterResult::class),
            $controllers,
            $container
    )
);

// VIEWS
require_once(__DIR__ . '/code/Views/views.php');
Romchik38\Site1\Views\views($container);

// CONTROLLERS
require_once(__DIR__ . '/code/Controllers/controllers.php');
Romchik38\Site1\Controllers\controllers($container);

// SERVER
$container->add(Server::CONTAINER_LOGGER_FILED, new EchoLogger());

return $container;
