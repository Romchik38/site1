<?php

declare(strict_types=1);

return function ($container) {
    $configDatabase = require_once(__DIR__ . '/../../config/private/database.php');

    // DATABASES
    $container->add(
        \Romchik38\Server\Models\Sql\DatabasePostgresql::class,
        new Romchik38\Server\Models\Sql\DatabasePostgresql($configDatabase)
    );
    
    $container->add(
        \Romchik38\Server\Api\Models\DatabaseInterface::class,
        $container->get(\Romchik38\Server\Models\Sql\DatabasePostgresql::class)
    );

    $container->add(
        \Romchik38\Site1\Models\Redirect\RedirectFactory::class,
        new \Romchik38\Site1\Models\Redirect\RedirectFactory()
    );
    
    return $container;
};