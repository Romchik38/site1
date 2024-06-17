<?php

declare(strict_types=1);

return function ($container) {
    $container->add(
        \Romchik38\Site1\Views\Html\Classes\Main\Index::class,
        new \Romchik38\Site1\Views\Html\Classes\Main\Index(
            function(...$args){
                $defaultView = require_once(__DIR__ . '/Layouts/defaultView.php');
                return call_user_func($defaultView, ...$args);
            }
        )
    );

    return $container;
};
