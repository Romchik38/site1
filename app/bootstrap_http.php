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

// VIEWS
$views = require_once(__DIR__ . '/code/Views/Html/views.php');
$views($container);

// CONTROLLERS
$controllers = require_once(__DIR__ . '/bootstrap/Http/controllers.php');
$controllers($container);

// SERVICES
$container->add(
    \Romchik38\Server\Services\Redirect::class, 
    function($container){
        return new \Romchik38\Server\Services\Redirect(
            $container->get(\Romchik38\Site1\Models\Redirect\RedirectRepository::class)
        );
    }
);

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

// SERVER
$container->add(Server::CONTAINER_LOGGER_FILED, new EchoLogger());

return $container;
