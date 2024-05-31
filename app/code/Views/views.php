<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views;

use Romchik38\Site1\Views\Main\Index;

function views($container) {
    $container->add(
        \Romchik38\Site1\Views\Main\Index::class,
        new \Romchik38\Site1\Views\Main\Index()
    );

    return $container;
};
