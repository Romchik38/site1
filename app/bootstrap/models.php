<?php

declare(strict_types=1);

return function ($container) {
    $config = require_once(__DIR__ . '/../config/database.php');

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

    $container->add(
        Romchik38\Site1\Models\User\UserFactory::class,
        new Romchik38\Site1\Models\User\UserFactory()
    );

    $container->add(
        Romchik38\Site1\Models\DTO\Login\LoginDTOFactory::class,
        new Romchik38\Site1\Models\DTO\Login\LoginDTOFactory()
    );

    $container->add(
        Romchik38\Site1\Models\DTO\Main\MainDTOFactory::class,
        new Romchik38\Site1\Models\DTO\Main\MainDTOFactory()
    );

    $container->add(
        Romchik38\Site1\Models\DTO\UserRegisterDTOFactory::class,
        new Romchik38\Site1\Models\DTO\UserRegisterDTOFactory()
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
    
    $container->add(
        \Romchik38\Site1\Models\User\UserRepository::class,
        function($container){
            return new \Romchik38\Site1\Models\User\UserRepository(
                $container->get(\Romchik38\Server\Models\DatabasePostgresql::class),
                $container->get(\Romchik38\Site1\Models\User\UserFactory::class),
                'users',
                'user_id'
            );
        }
    );


    return $container;
};