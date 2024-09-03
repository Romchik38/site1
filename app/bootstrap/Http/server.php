<?php

declare(strict_types=1);

return function ($container) {
    $container->add(
        \Romchik38\Server\Servers\Http\DefaultServer::class,
        new \Romchik38\Server\Servers\Http\DefaultServer(
            $container->get(\Romchik38\Server\Api\Router\RouterInterface::class),
            new \Romchik38\Server\Controllers\Controller(
                'server-error',
                false,
                $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
                $container->get(\Romchik38\Site1\Controllers\ServerError\DefaultAction::class)
            ),
            $container->get(\Romchik38\Server\Api\Services\LoggerServerInterface::class)
        )
    );

    /** @todo change to Http interface */
    $container->add(
        \Romchik38\Server\Api\Servers\ServerInterface::class,
        $container->get(\Romchik38\Server\Servers\Http\DefaultServer::class)
    );

    return $container;
};
