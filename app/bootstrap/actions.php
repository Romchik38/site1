<?php

declare(strict_types=1);

return function ($container) {

    $container->add(
        \Romchik38\Site1\Controllers\Root\DefaultAction::class,
        new \Romchik38\Site1\Controllers\Root\DefaultAction(
            $container->get(\Romchik38\Site1\Api\Views\MainPageViewInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\Page\PageRepositoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site1\Controllers\Root\DynamicAction::class,
        new \Romchik38\Site1\Controllers\Root\DynamicAction(
            $container->get(\Romchik38\Site1\Api\Views\MainPageViewInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\Page\PageRepositoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface::class)
        )
    );

    return $container;
};