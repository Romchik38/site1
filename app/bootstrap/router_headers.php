<?php

declare(strict_types=1);

return function ($container) {
    $container->add(
        \Romchik38\Site1\Http\Router\RouterHeaders\Auth::class,
        new \Romchik38\Site1\Http\Router\RouterHeaders\Auth()
    );

    $container->add(
        \Romchik38\Site1\Http\Router\RouterHeaders\Changepassword::class,
        new \Romchik38\Site1\Http\Router\RouterHeaders\Changepassword()
    );
    
    return $container;
};