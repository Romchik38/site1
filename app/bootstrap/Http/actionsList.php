<?php

declare(strict_types=1);

use Romchik38\Server\Api\Router\Http\HttpRouterInterface;
use Romchik38\Server\Controllers\Controller;

return function ($container) {

    // Init
    $root = new Controller(
        'root',
        $container->get(\Romchik38\Site1\Controllers\Root\DefaultAction::class),
        $container->get(\Romchik38\Site1\Controllers\Root\DynamicAction::class),
    );

    $login = new Controller(
        'login',
        $container->get(\Romchik38\Site1\Controllers\Login\DefaultAction::class),
        $container->get(\Romchik38\Site1\Controllers\Login\DynamicAction::class)
    );

    // Routing
    $root->setChild($login);
   
    return [
        HttpRouterInterface::REQUEST_METHOD_GET => $root
    ];
};