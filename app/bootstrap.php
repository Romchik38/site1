<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Routers\DefaultRouter;
use Romchik38\Server\Results\DefaultRouterResult;
use Romchik38\Server\Api\Server;
use Romchik38\Site1\Stubs\EchoLogger;
use Romchik38\Site1\Models\Redirects\RedirectRepository;

$container = new Container();

// MODELS
$models = require_once(__DIR__ . '/code/Models/models.php');
$models($container);

// VIEWS
$views = require_once(__DIR__ . '/code/Views/views.php');
$views($container);

// CONTROLLERS
$controllers = require_once(__DIR__ . '/code/Controllers/controllers.php');
$controllers($container);

// ROUTER
$container->add(DefaultRouterResult::class, new DefaultRouterResult(
    /** default response, headers, statusCode */
));
$controllersList = require_once(__DIR__ . '/code/Controllers/controllersList.php');
$container->add(
    DefaultRouter::class, new DefaultRouter(
            $container->get(DefaultRouterResult::class),
            $controllersList,
            $container,
            null,
            $container->get(Romchik38\Site1\Controllers\Redirect::class)
    )
);

// SERVER
$container->add(Server::CONTAINER_LOGGER_FILED, new EchoLogger());

return $container;
