<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Routers\DefaultRouter;
use Romchik38\Server\Results\DefaultRouterResult;
use Romchik38\Server\Api\Server;
use Romchik38\Site1\Stubs\EchoLogger;

$container = new Container();
$container->add(
    DefaultRouter::class, 
    new DefaultRouter(new DefaultRouterResult())
);
$container->add(Server::CONTAINER_LOGGER_FILED, new EchoLogger());

return $container;