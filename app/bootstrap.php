<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Routers\DefaultRouter;

$container = new Container();
$container->add(DefaultRouter::class, new DefaultRouter());

return $container;