<?php

declare(strict_types=1);

return function ($container) {
    $container->add(
        \Romchik38\Server\Results\DefaultControllerResult::class,
        new \Romchik38\Server\Results\DefaultControllerResult()
    );
    // /
    $container->add(
        \Romchik38\Site1\Controllers\Main\Index::class, 
        function($container){
            return new \Romchik38\Site1\Controllers\Main\Index(
                $container->get(\Romchik38\Server\Results\DefaultControllerResult::class),
                $container->get(\Romchik38\Site1\Views\Html\Classes\Main\Index::class),
                $container->get(\Romchik38\Site1\Models\Page\PageRepository::class)
            );
        }
    );
    // /login
    $container->add(
        \Romchik38\Site1\Controllers\Login\Index::class, 
        function($container){
            return new \Romchik38\Site1\Controllers\Login\Index(
                $container->get(\Romchik38\Server\Results\DefaultControllerResult::class),
                $container->get(\Romchik38\Site1\Views\Html\Classes\Main\Index::class)
            );
        }
    );
    // redirect
    $container->add(
        \Romchik38\Server\Controllers\Redirect::class, 
        function($container){
            return new \Romchik38\Server\Controllers\Redirect(
                $container->get(\Romchik38\Server\Results\DefaultControllerResult::class),
                $container->get(\Romchik38\Site1\Models\Redirect\RedirectRepository::class)
            );
        }
    );
    return $container;
};