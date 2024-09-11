<?php

declare(strict_types=1);

return function ($container) {

    // REPOSITORIES
    $container->add(
        \Romchik38\Site1\Models\Sql\Page\PageRepository::class,
        function ($container) {
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
        function ($container) {
            return new \Romchik38\Site1\Models\Sql\Redirect\RedirectRepository(
                $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
                $container->get(\Romchik38\Site1\Models\Redirect\RedirectFactory::class),
                'redirects',
                'redirect_id'
            );
        }
    );

    $container->add(
        \Romchik38\Site1\Models\Sql\User\UserRepository::class,
        function ($container) {
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
        function ($container) {
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
        function ($container) {
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

    $container->add(
        \Romchik38\Site1\Models\Sql\Virtual\Link\VirtualLinkRepository::class,
        function ($container) {
            return new \Romchik38\Site1\Models\Sql\Virtual\Link\VirtualLinkRepository(
                $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
                $container->get(\Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkFactoryInterface::class),
                ['menu_to_links.*', 'menu_links.name', 'menu_links.url', 'menu_links.description'],
                ['menu_links', 'menu_to_links']
            );
        }
    );
    $container->add(
        \Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkRepositoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\Virtual\Link\VirtualLinkRepository::class)
    );

    $container->add(
        \Romchik38\Site1\Models\Sql\Menu\MenuModelRepository::class,
        function ($container) {
            return new \Romchik38\Site1\Models\Sql\Menu\MenuModelRepository(
                $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
                $container->get(\Romchik38\Site1\Api\Models\Menu\MenuModelFactoryInterface::class),
                'menu',
                'menu_id'
            );
        }
    );
    $container->add(
        \Romchik38\Site1\Api\Models\Menu\MenuModelRepositoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\Menu\MenuModelRepository::class)
    );

    $container->add(
        \Romchik38\Site1\Models\Sql\MenuLinks\MenuLinksRepository::class,
        new \Romchik38\Site1\Models\Sql\MenuLinks\MenuLinksRepository(
            $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\MenuLinks\MenuLinksFactoryInterface::class),
            'menu_links',
            'link_id'
        )
    );
    $container->add(
        \Romchik38\Site1\Api\Models\MenuLinks\MenuLinksRepositoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\MenuLinks\MenuLinksRepository::class)
    );

    $container->add(
        \Romchik38\Site1\Models\Sql\MenuToLinks\MenuToLinksRepository::class,
        function ($container) {
            return new \Romchik38\Site1\Models\Sql\MenuToLinks\MenuToLinksRepository(
                $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
                $container->get(\Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksFactoryInterface::class),
                $container->get(\Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksIdDTOFactoryInterface::class),
                'menu_to_links'
            );
        }
    );
    $container->add(
        \Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksRepositoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\MenuToLinks\MenuToLinksRepository::class)
    );

    $container->add(
        \Romchik38\Site1\Models\Sql\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepository::class,
        new \Romchik38\Site1\Models\Sql\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepository(
            $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelFactoryInterface::class),
            ['recaptcha.*', 'recaptcha_google.score'],
            ['recaptcha', 'recaptcha_google']
        )
    );
    $container->add(
        \Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepositoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepository::class)
    );

    return $container;
};
