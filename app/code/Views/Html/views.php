<?php

declare(strict_types=1);

return function ($container) {
    $container->add(
        \Romchik38\Site1\Views\Html\Classes\Metadata::class,
        new \Romchik38\Site1\Views\Html\Classes\Metadata(
            $container->get(\Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOFactoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Nav\NavDTOFactoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Footer\FooterDTOFactoryInterface::class),
            $container->get(\Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface::class),
            2,
            $container->get(\Psr\Log\LoggerInterface::class),
            $container->get(\Romchik38\Site1\Api\Services\Menu\StaticMenuServiceInterface::class),
            $container->get(\Romchik38\Server\Api\Services\SitemapInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\DTO\Breadcrumb\BreadcrumbDTOFactoryInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\MenuLinks\MenuLinksRepositoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site1\Api\Views\MetadataInterface::class,
        $container->get(\Romchik38\Site1\Views\Html\Classes\Metadata::class)
    );

    // DEFAULT
    $container->add(
        \Romchik38\Site1\Views\Html\Classes\DefaultPageView::class,
        new \Romchik38\Site1\Views\Html\Classes\DefaultPageView(
            function(...$args){
                $defaultView = require(__DIR__ . '/Layouts/defaultView.php');
                return call_user_func($defaultView, ...$args);
            },
            require_once(__DIR__ . '/Tamplates/Default/index.php'),
            $container->get(\Romchik38\Site1\Api\Views\MetadataInterface::class) 
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
                $defaultView = require(__DIR__ . '/Layouts/defaultView.php');
                return call_user_func($defaultView, ...$args);
            },
            require_once(__DIR__ . '/Tamplates/Main/index.php'),
            $container->get(\Romchik38\Site1\Api\Views\MetadataInterface::class)
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
                $defaultView = require(__DIR__ . '/Layouts/defaultView.php');
                return call_user_func($defaultView, ...$args);
            },
            require_once(__DIR__ . '/Tamplates/Login/index.php'),
            $container->get(\Romchik38\Site1\Api\Views\MetadataInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site1\Api\Views\LoginPageViewInterface::class,
        $container->get(\Romchik38\Site1\Views\Html\Classes\Login\Index::class)
    );

    return $container;
};
