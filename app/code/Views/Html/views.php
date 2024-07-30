<?php

declare(strict_types=1);

return function ($container) {
    // DEFAULT
    $container->add(
        \Romchik38\Site1\Views\Html\Classes\DefaultPageView::class,
        new \Romchik38\Site1\Views\Html\Classes\DefaultPageView(
            function(...$args){
                $defaultView = require_once(__DIR__ . '/Layouts/defaultView.php');
                return call_user_func($defaultView, ...$args);
            },
            require_once(__DIR__ . '/Tamplates/defaultTemplate.php')
        )
    );
    
    $container->add(
        \Romchik38\Site1\Api\Views\DefaultPageViewInterface::class,
        $container->get(\Romchik38\Site1\Views\Html\Classes\DefaultPageView::class)
    );

    // MAIN 
    $container->add(
        \Romchik38\Site1\Views\Html\Classes\Main\Index::class,
        new \Romchik38\Site1\Views\Html\Classes\Main\Index(
            function(...$args){
                $defaultView = require_once(__DIR__ . '/Layouts/defaultView.php');
                return call_user_func($defaultView, ...$args);
            },
            require_once(__DIR__ . '/Tamplates/Main/index.php')
        )
    );

    $container->add(
        \Romchik38\Site1\Api\Views\MainPageViewInterface::class,
        $container->get(\Romchik38\Site1\Views\Html\Classes\Main\Index::class)
    );


    // LOGIN
    $container->add(
        \Romchik38\Site1\Views\Html\Classes\Login\Index::class,
        new \Romchik38\Site1\Views\Html\Classes\Login\Index(
            function(...$args){
                $defaultView = require_once(__DIR__ . '/Layouts/defaultView.php');
                return call_user_func($defaultView, ...$args);
            },
            require_once(__DIR__ . '/Tamplates/Login/index.php')
        )
    );

    $container->add(
        \Romchik38\Site1\Api\Views\LoginPageViewInterface::class,
        $container->get(\Romchik38\Site1\Views\Html\Classes\Login\Index::class)
    );

    return $container;
};
