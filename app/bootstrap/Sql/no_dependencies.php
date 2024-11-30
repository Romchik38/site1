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
        \Romchik38\Site1\Models\Sql\Page\PageFactory::class,
        new Romchik38\Site1\Models\Sql\Page\PageFactory()
    );

    $container->add(
        \Romchik38\Site1\Models\Redirect\RedirectFactory::class,
        new \Romchik38\Site1\Models\Redirect\RedirectFactory()
    );
    
    $container->add(
        \Romchik38\Site1\Models\Sql\User\UserFactory::class,
        new \Romchik38\Site1\Models\Sql\User\UserFactory
    );
    $container->add(
        \Romchik38\Site1\Domain\User\UserFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\User\UserFactory::class)
    );

    $container->add(
        \Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailFactory::class,
        new Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailFactory::class)
    );
    
    return $container;
};