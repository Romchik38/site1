<?php

declare(strict_types=1);

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Router\Http\HttpRouterInterface;

return function ($container) {

    $s = ControllerInterface::PATH_SEPARATOR;
    $a = ControllerInterface::PATH_DYNAMIC_ALL;

    $container->add(
        \Romchik38\Site1\Router\Http\RouterHeaders\Auth::class,
        new \Romchik38\Site1\Router\Http\RouterHeaders\Auth()
    );

    $container->add(
        \Romchik38\Site1\Router\Http\RouterHeaders\Changepassword::class,
        new \Romchik38\Site1\Router\Http\RouterHeaders\Changepassword()
    );
    
    return [
        HttpRouterInterface::REQUEST_METHOD_GET => [
            'root' . $s . 'changepassword' => new \Romchik38\Site1\Router\Http\RouterHeaders\Changepassword()
        ],
        HttpRouterInterface::REQUEST_METHOD_POST => [
            'root' . $s . 'auth' . $s . $a => new \Romchik38\Site1\Router\Http\RouterHeaders\Auth()
        ]
    ];
};