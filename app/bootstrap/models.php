<?php

declare(strict_types=1);

return function ($container) {
    $config = require_once(__DIR__ . '/../config/database.php');

    // DATABASES
    $container->add(
        Romchik38\Server\Models\Sql\DatabasePostgresql::class,
        new Romchik38\Server\Models\Sql\DatabasePostgresql($config)
    );
    // FACTORIES
    $container->add(
        Romchik38\Site1\Models\Sql\Page\PageFactory::class,
        new Romchik38\Site1\Models\Sql\Page\PageFactory()
    );
    $container->add(
        Romchik38\Site1\Models\Sql\Redirect\RedirectFactory::class,
        new Romchik38\Site1\Models\Sql\Redirect\RedirectFactory()
    );

    $container->add(
        Romchik38\Site1\Models\Sql\User\UserFactory::class,
        new Romchik38\Site1\Models\Sql\User\UserFactory()
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

    $container->add(
        Romchik38\Server\Models\EntityFactory::class,
        new Romchik38\Server\Models\EntityFactory()
    );

    $container->add(
        Romchik38\Server\Models\DTO\Email\EmailDTOFactory::class,
        new Romchik38\Server\Models\DTO\Email\EmailDTOFactory()
    );

    // REPOSITORIES
    $container->add(
        \Romchik38\Site1\Models\Sql\Page\PageRepository::class,
        function($container){
            return new \Romchik38\Site1\Models\Sql\Page\PageRepository(
                $container->get(\Romchik38\Server\Models\Sql\DatabasePostgresql::class),
                $container->get(\Romchik38\Site1\Models\Sql\Page\PageFactory::class),
                'pages',
                'page_id'
            );
        }
    );

    $container->add(
        \Romchik38\Site1\Models\Sql\Redirect\RedirectRepository::class,
        function($container){
            return new \Romchik38\Site1\Models\Sql\Redirect\RedirectRepository(
                $container->get(\Romchik38\Server\Models\Sql\DatabasePostgresql::class),
                $container->get(\Romchik38\Site1\Models\Sql\Redirect\RedirectFactory::class),
                'redirects',
                'redirect_id'
            );
        }
    );
    
    $container->add(
        \Romchik38\Site1\Models\Sql\User\UserRepository::class,
        function($container){
            return new \Romchik38\Site1\Models\Sql\User\UserRepository(
                $container->get(\Romchik38\Server\Models\Sql\DatabasePostgresql::class),
                $container->get(\Romchik38\Site1\Models\Sql\User\UserFactory::class),
                'users',
                'user_id'
            );
        }
    );

    $container->add(
        \Romchik38\Server\Models\Sql\Entity\EntityRepository::class,
        function($container){
            return new \Romchik38\Server\Models\Sql\Entity\EntityRepository(
                $container->get(\Romchik38\Server\Models\Sql\DatabasePostgresql::class),
                $container->get(Romchik38\Server\Models\EntityFactory::class),
                'entities',
                'entity_field',
                'entity_id',
                'field_name',
                'value'
            );
        }
    );

    return $container;
};