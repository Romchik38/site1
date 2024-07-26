<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Routers\DefaultRouter;
use Romchik38\Server\Results\DefaultRouterResult;
use Romchik38\Server\Api\Server;
use Romchik38\Site1\Stubs\EchoLogger;

$container = new Container();

// MODELS
$models = require_once(__DIR__ . '/bootstrap/models.php');
$models($container);

// SERVICES 
$services = require_once(__DIR__ . '/bootstrap/services.php');
$services($container);

// VIEWS
$views = require_once(__DIR__ . '/code/Views/Html/views.php');
$views($container);

// CONTROLLERS
$controllers = require_once(__DIR__ . '/bootstrap/Http/controllers.php');
$controllers($container);

// ROUTER
$container->add(DefaultRouterResult::class, new DefaultRouterResult(
    /** default response, headers, statusCode */
));
$controllersList = require_once(__DIR__ . '/bootstrap/Http/controllersList.php');
$container->add(
    DefaultRouter::class, new DefaultRouter(
            $container->get(DefaultRouterResult::class),
            $controllersList,
            $container,
            null,
            $container->get(Romchik38\Server\Services\Redirect::class)
    )
);

// ROUTER HEADERS
$headers = require_once(__DIR__ . '/bootstrap/router_headers.php');
$headers($container);

// SERVER
$container->add(
    Server::CONTAINER_LOGGER_FIELD, 
    $container->get(\Romchik38\Server\Services\Logger\Loggers\FileLogger::class)
);

return $container;
