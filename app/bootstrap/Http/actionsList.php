<?php

declare(strict_types=1);

use Romchik38\Server\Api\Routers\Http\HttpRouterInterface;
use Romchik38\Server\Controllers\Controller;
use Romchik38\Server\Api\Services\Mappers\ControllerTreeInterface;
use Romchik38\Server\Routers\Http\ControllersCollection;
use Romchik38\Site1\Middlewares\Response\ApiContentTypeJson;

return function ($container) {

    //////////////////
    //
    //      GET
    //
    //////////////////
    $root = new Controller(
        ControllerTreeInterface::ROOT_NAME,
        true,
        $container->get(\Romchik38\Site1\Controllers\Root\DefaultAction::class),
        $container->get(\Romchik38\Site1\Controllers\Root\DynamicAction::class),
    );

    $login = new Controller(
        'login',
        true,
        $container->get(\Romchik38\Site1\Controllers\Login\DefaultAction::class),
        $container->get(\Romchik38\Site1\Controllers\Login\DynamicAction::class)
    );

    $changepassword = new Controller(
        'changepassword',
        false,
        $container->get(\Romchik38\Site1\Controllers\Changepassword\DefaultAction::class)
    );

    $sitemap = new Controller(
        'sitemap',
        true,
        $container->get(Romchik38\Site1\Controllers\Sitemap\DefaultAction::class)
    );

    // API
    $api = new Controller(
        'api',
        false
    );

    $userinfo = new Controller(
        'userinfo',
        false,
        $container->get(\Romchik38\Site1\Controllers\Api\Userinfo\DefaultAction::class)
    );

    $api->setChild($userinfo);

    $root->setChild($login)->setChild($changepassword)->setChild($sitemap)->setChild($api);

    // Response Middlewares
    $api->addResponseMiddleware(new ApiContentTypeJson);

    //////////////////
    //
    //      POST
    //
    //////////////////
    $rootPost = new Controller(ControllerTreeInterface::ROOT_NAME);

    $authPost = new Controller(
        'auth',
        false,
        null,
        $container->get(\Romchik38\Site1\Controllers\Auth\DynamicAction::class)
    );
    
    $rootPost->setChild($authPost);

    $collection = (new ControllersCollection)
        ->setController($root, HttpRouterInterface::REQUEST_METHOD_GET)
        ->setController($rootPost, HttpRouterInterface::REQUEST_METHOD_POST);

    return $collection;
};