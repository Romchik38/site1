<?php

declare(strict_types=1);

use Romchik38\Server\Api\Router\Http\HttpRouterInterface;
use Romchik38\Server\Controllers\Controller;

return function ($container) {

    // GET
    $root = new Controller(
        'root',
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site1\Controllers\Root\DefaultAction::class),
        $container->get(\Romchik38\Site1\Controllers\Root\DynamicAction::class),
    );

    $login = new Controller(
        'login',
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site1\Controllers\Login\DefaultAction::class),
        $container->get(\Romchik38\Site1\Controllers\Login\DynamicAction::class)
    );

    $root->setChild($login);

    // POST
    $rootPost = new Controller(
        'root',
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site1\Controllers\DefaultActionStub::class),

    );

    $authPost = new Controller(
        'auth',
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site1\Controllers\DefaultActionStub::class),
        $container->get(\Romchik38\Site1\Controllers\Auth\DynamicAction::class)
    );
    
    $rootPost->setChild($authPost);

    return [
        HttpRouterInterface::REQUEST_METHOD_GET => $root,
        HttpRouterInterface::REQUEST_METHOD_POST => $rootPost
    ];
};