<?php

declare(strict_types=1);

return function ($container) {

    // REPOSITORIES
    $container->add(
        \Romchik38\Site1\Models\Sql\Page\PageRepository::class,
        function($container){
            return new \Romchik38\Site1\Models\Sql\Page\PageRepository(
                $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
                $container->get(\Romchik38\Site1\Models\Sql\Page\PageFactory::class),
                'pages',
                'page_id'
            );
        }
    );

    $container->add(
        \Romchik38\Site1\Api\Models\Page\PageRepositoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\Page\PageRepository::class)
    );

    $container->add(
        \Romchik38\Site1\Models\Sql\Redirect\RedirectRepository::class,
        function($container){
            return new \Romchik38\Site1\Models\Sql\Redirect\RedirectRepository(
                $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
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
                $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
                $container->get(\Romchik38\Site1\Api\Models\User\UserFactoryInterface::class),
                'users',
                'user_id'
            );
        }
    );

    $container->add(
        \Romchik38\Site1\Api\Models\User\UserRepositoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\User\UserRepository::class)
    );

    $container->add(
        \Romchik38\Server\Models\Sql\Entity\EntityRepository::class,
        function($container){
            return new \Romchik38\Server\Models\Sql\Entity\EntityRepository(
                $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
                $container->get(\Romchik38\Server\Api\Models\Entity\EntityFactoryInterface::class),
                'entities',
                'entity_field',
                'entity_id',
                'field_name',
                'value'
            );
        }
    );

    $container->add(
        \Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface::class,
        $container->get(\Romchik38\Server\Models\Sql\Entity\EntityRepository::class)
    );

    $container->add(
        \Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailRepository::class,
        function($container){
            return new \Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailRepository(
                $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
                $container->get(\Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailFactoryInterface::class),
                'recovery_email',
                'email'
            );
        }
    );

    $container->add(
        \Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailRepositoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailRepository::class)
    );

    return $container;
};