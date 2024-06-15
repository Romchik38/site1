<?php

declare(strict_types=1);

return function ($container) {
    $container->add(
        \Romchik38\Server\Results\DefaultControllerResult::class,
        new \Romchik38\Server\Results\DefaultControllerResult()
    );
    // /
    $container->add(
        \Romchik38\Site1\Controllers\GET\Main\Index::class, 
        function($container){
            return new \Romchik38\Site1\Controllers\GET\Main\Index(
                $container->get(\Romchik38\Server\Results\DefaultControllerResult::class),
                $container->get(\Romchik38\Site1\Views\Main\Index::class),
                $container->get(\Romchik38\Site1\Models\PageRepository::class)
            );
        }
    );
    // /login
    $container->add(
        \Romchik38\Site1\Controllers\GET\Login\Index::class, 
        function($container){
            return new \Romchik38\Site1\Controllers\GET\Login\Index(
                $container->get(\Romchik38\Server\Results\DefaultControllerResult::class),
                $container->get(\Romchik38\Site1\Views\Main\Index::class)
            );
        }
    );
    // redirect
    $container->add(
        \Romchik38\Site1\Controllers\Redirect::class, 
        function($container){
            return new \Romchik38\Site1\Controllers\Redirect(
                $container->get(\Romchik38\Server\Results\DefaultControllerResult::class),
                $container->get(\Romchik38\Site1\Models\Redirects\RedirectRepository::class)
            );
        }
    );
    return $container;
};