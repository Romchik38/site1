<?php

declare(strict_types=1);

return function ($container) {
    $config = require_once(__DIR__ . '/../../config/database.php');

    // DATABASES
    $container->add(
        Romchik38\Server\Models\DatabasePostgresql::class,
        new Romchik38\Server\Models\DatabasePostgresql($config)
    );
    // FACTORIES
    $container->add(
        Romchik38\Site1\Models\Page\PageFactory::class,
        new Romchik38\Site1\Models\Page\PageFactory()
    );
    $container->add(
        Romchik38\Site1\Models\Redirect\RedirectFactory::class,
        new Romchik38\Site1\Models\Redirect\RedirectFactory()
    );

    // REPOSITORIES
    $container->add(
        \Romchik38\Site1\Models\Page\PageRepository::class,
        function($container){
            return new \Romchik38\Site1\Models\Page\PageRepository(
                $container->get(\Romchik38\Server\Models\DatabasePostgresql::class),
                $container->get(\Romchik38\Site1\Models\Page\PageFactory::class),
                'pages',
                'page_id'
            );
        }
    );

    $container->add(
        \Romchik38\Site1\Models\Redirect\RedirectRepository::class,
        function($container){
            return new \Romchik38\Site1\Models\Redirect\RedirectRepository(
                $container->get(\Romchik38\Server\Models\DatabasePostgresql::class),
                $container->get(\Romchik38\Site1\Models\Redirect\RedirectFactory::class),
                'redirects',
                'redirect_id'
            );
        }
    );


    return $container;
};