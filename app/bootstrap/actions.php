<?php

declare(strict_types=1);

return function ($container) {

    $container->add(
        \Romchik38\Site1\Controllers\Root\DefaultAction::class,
        new \Romchik38\Site1\Controllers\Root\DefaultAction()
    );

    return $container;
};