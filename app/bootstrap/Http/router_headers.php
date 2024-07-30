<?php

declare(strict_types=1);

return function ($container) {
    $container->add(
        \Romchik38\Site1\Router\Http\RouterHeaders\Auth::class,
        new \Romchik38\Site1\Router\Http\RouterHeaders\Auth()
    );

    $container->add(
        \Romchik38\Site1\Router\Http\RouterHeaders\Changepassword::class,
        new \Romchik38\Site1\Router\Http\RouterHeaders\Changepassword()
    );
    
    return $container;
};