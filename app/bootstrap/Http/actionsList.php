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

    $changepassword = new Controller(
        'changepassword',
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site1\Controllers\Changepassword\DefaultAction::class)
    );

    $sitemap = new Controller(
        'sitemap',
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(Romchik38\Site1\Controllers\Sitemap\DefaultAction::class)
    );

    $root->setChild($login)->setChild($changepassword)->setChild($sitemap);

    // POST
    $rootPost = new Controller('root');

    $authPost = new Controller(
        'auth',
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        null,
        $container->get(\Romchik38\Site1\Controllers\Auth\DynamicAction::class)
    );
    
    $rootPost->setChild($authPost);

    return [
        HttpRouterInterface::REQUEST_METHOD_GET => $root,
        HttpRouterInterface::REQUEST_METHOD_POST => $rootPost
    ];
};