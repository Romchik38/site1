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

    return $container;
};
