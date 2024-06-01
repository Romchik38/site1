<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views;

function views($container) {
    $container->add(
        \Romchik38\Site1\Views\Main\Index::class,
        new \Romchik38\Site1\Views\Main\Index(
            function(...$args){
                require_once(__DIR__ . '/Html/defaultView.php');
                return \Romchik38\Site1\Views\Html\defaultView(...$args);
            }
        )
    );

    return $container;
};
