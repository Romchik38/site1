<?php

declare(strict_types=1);

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Router\Http\HttpRouterInterface;
use Romchik38\Server\Api\Services\SitemapInterface;

return function ($container) {

    $s = ControllerInterface::PATH_SEPARATOR;
    $a = ControllerInterface::PATH_DYNAMIC_ALL;

    $container->add(
        \Romchik38\Site1\Router\Http\RouterHeaders\Auth::class,
        new \Romchik38\Site1\Router\Http\RouterHeaders\Auth(
            HttpRouterInterface::REQUEST_METHOD_POST,
            SitemapInterface::ROOT_NAME . $s . 'auth' . $s . $a
        )
    );

    $container->add(
        \Romchik38\Site1\Router\Http\RouterHeaders\Changepassword::class,
        new \Romchik38\Site1\Router\Http\RouterHeaders\Changepassword(
            HttpRouterInterface::REQUEST_METHOD_GET,
            SitemapInterface::ROOT_NAME . $s . 'changepassword'
        )
    );
    
    return [
        HttpRouterInterface::REQUEST_METHOD_GET => [
            SitemapInterface::ROOT_NAME . $s . 'changepassword' => $container->get(\Romchik38\Site1\Router\Http\RouterHeaders\Changepassword::class)
        ],
        HttpRouterInterface::REQUEST_METHOD_POST => [
            SitemapInterface::ROOT_NAME . $s . 'auth' . $s . $a => $container->get(\Romchik38\Site1\Router\Http\RouterHeaders\Auth::class)
        ]
    ];
};