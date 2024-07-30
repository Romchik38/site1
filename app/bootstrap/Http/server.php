<?php

declare(strict_types=1);

return function ($container) {
    $container->add(
        \Romchik38\Server\Servers\Http\DefaultServer::class,
        new \Romchik38\Server\Servers\Http\DefaultServer(
            $container->get(\Romchik38\Server\Api\Router\RouterInterface::class),
            $container->get(\Romchik38\Server\Api\Services\LoggerServerInterface::class)
        )
    );
    
    $container->add(
        \Romchik38\Server\Api\Servers\ServerInterface::class,
        $container->get(\Romchik38\Server\Servers\Http\DefaultServer::class)
    );

    return $container;
};
