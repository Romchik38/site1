<?php

declare(strict_types=1);

use Romchik38\Site1\Models\PageRepository;
use Romchik38\Server\Models\DatabasePostgresql;
use Romchik38\Site1\Models\PageFactory;

return function ($container) {
    $config = require_once(__DIR__ . '/../../config/database.php');

    // DATABASES
    $container->add(
        Romchik38\Server\Models\DatabasePostgresql::class,
        new Romchik38\Server\Models\DatabasePostgresql($config)
    );
    // FACTORIES
    $container->add(
        Romchik38\Site1\Models\PageFactory::class,
        new Romchik38\Site1\Models\PageFactory()
    );

    // REPOSITORIES
    $container->add(
        \Romchik38\Site1\Models\PageRepository::class,
        function($container){
            return new \Romchik38\Site1\Models\PageRepository(
                $container->get(\Romchik38\Server\Models\DatabasePostgresql::class),
                $container->get(\Romchik38\Site1\Models\PageFactory::class),
                'pages',
                'page_id'
            );
        }
    );


    return $container;
};