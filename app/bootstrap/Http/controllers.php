<?php

declare(strict_types=1);

return function ($container) {
    // /
    $container->add(
        \Romchik38\Site1\Controllers\Main\Index::class, 
        function($container){
            return new \Romchik38\Site1\Controllers\Main\Index(
                $container->get(\Romchik38\Site1\Views\Html\Classes\DefaultPageView::class),
                $container->get(\Romchik38\Site1\Models\Page\PageRepository::class)
            );
        }
    );
    // /login
    $container->add(
        \Romchik38\Site1\Controllers\Login\Index::class, 
        function($container){
            return new \Romchik38\Site1\Controllers\Login\Index(
                $container->get(\Romchik38\Site1\Views\Html\Classes\DefaultPageView::class)
            );
        }
    );

    return $container;
};