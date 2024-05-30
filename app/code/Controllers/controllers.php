<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers;

use Romchik38\Site1\Controllers\GET\Main\Index;
use Romchik38\Server\Results\DefaultControllerResult;

function controllers($container) {
    $container->add(
        \Romchik38\Server\Results\DefaultControllerResult::class,
        new \Romchik38\Server\Results\DefaultControllerResult()
    );

    $container->add(
        \Romchik38\Site1\Controllers\GET\Main\Index::class, 
        function($container){
            return new \Romchik38\Site1\Controllers\GET\Main\Index(
                $container->get(\Romchik38\Server\Results\DefaultControllerResult::class)
            );
        }
    );
    return $container;
};
