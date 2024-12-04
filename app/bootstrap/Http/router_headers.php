<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Routers\Http\HttpRouterInterface;
use Romchik38\Server\Api\Services\Mappers\ControllerTreeInterface;

return function (Container $container) {

    $s = ControllerInterface::PATH_SEPARATOR;
    $a = ControllerInterface::PATH_DYNAMIC_ALL;

    $container->add(
        \Romchik38\Site1\Router\Http\RouterHeaders\Auth::class,
        new \Romchik38\Site1\Router\Http\RouterHeaders\Auth(
            ControllerTreeInterface::ROOT_NAME . $s . 'auth' . $s . $a,
            HttpRouterInterface::REQUEST_METHOD_POST
        )
    );

    $container->add(
        \Romchik38\Site1\Router\Http\RouterHeaders\Changepassword::class,
        new \Romchik38\Site1\Router\Http\RouterHeaders\Changepassword(
            ControllerTreeInterface::ROOT_NAME . $s . 'changepassword',
            HttpRouterInterface::REQUEST_METHOD_GET
        )
    );

    $container->add(
        \Romchik38\Site1\Router\Http\RouterHeaders\Api\Userinfo::class,
        new \Romchik38\Site1\Router\Http\RouterHeaders\Api\Userinfo(
            ControllerTreeInterface::ROOT_NAME . $s . 'api' . $s . 'userinfo',
            HttpRouterInterface::REQUEST_METHOD_GET
        )
    );

    $headersList = [
        $container->get(\Romchik38\Site1\Router\Http\RouterHeaders\Changepassword::class),
        $container->get(\Romchik38\Site1\Router\Http\RouterHeaders\Auth::class),
        $container->get(\Romchik38\Site1\Router\Http\RouterHeaders\Api\Userinfo::class)
    ];

    $container->add(
        \Romchik38\Server\Routers\Http\HeadersCollection::class,
        new \Romchik38\Server\Routers\Http\HeadersCollection(
            $headersList
        )
    );
    $container->add(
        Romchik38\Server\Api\Routers\Http\HeadersCollectionInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\HeadersCollection::class)
    );

    return $container;
};
