<?php

declare(strict_types=1);

use Romchik38\Server\Api\Router\Http\HttpRouterInterface;
use Romchik38\Server\Controllers\Controller;

return function ($container) {

    $root = new Controller(
        'root',
        $container->get(\Romchik38\Site1\Controllers\Root\DefaultAction::class)
    );

    return [
        HttpRouterInterface::REQUEST_METHOD_GET => $root
    ];
};