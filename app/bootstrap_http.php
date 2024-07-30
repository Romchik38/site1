<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Server;

$container = new Container();

// No dependencies
$no_dependencies = require_once(__DIR__ . '/bootstrap/1_no_dependencies.php');
$no_dependencies($container);

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
$controllersList = require_once(__DIR__ . '/bootstrap/Http/controllersList.php');
$container->add(
    \Romchik38\Server\Routers\Http\DefaultRouter::class, 
    new \Romchik38\Server\Routers\Http\DefaultRouter(
        $container->get(\Romchik38\Server\Results\DefaultRouterResult::class),
        $controllersList,
        $container,
        null,
        $container->get(\Romchik38\Server\Api\Services\RedirectInterface::class)
    )
);

$container->add(
    \Romchik38\Server\Api\Router\RouterInterface::class,
    $container->get(Romchik38\Server\Routers\DefaultRouter::class)
);

// ROUTER HEADERS
$headers = require_once(__DIR__ . '/bootstrap/router_headers.php');
$headers($container);

// SERVER

$container->add(
    \Romchik38\Server\Servers\Http\DefaultServer::class,
    new \Romchik38\Server\Servers\Http\DefaultServer(
        $container->get(\Romchik38\Server\Api\Router\RouterInterface::class),
        $container->get(\Romchik38\Server\Api\Services\LoggerServerInterface::class)
    )
);

$container->add(
    \Romchik38\Server\Api\Servers\ServerInterface::class,
    $container->get(\Romchik38\Server\Servers\Http\DefaultServer::class)
);

return $container;
