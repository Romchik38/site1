<?php

declare(strict_types=1);

return function ($container) {
    // REQUEST
    $container->add(
        \Romchik38\Site1\Services\Http\Request::class,
        new \Romchik38\Site1\Services\Http\Request(
            $container->get(\Romchik38\Site1\Api\Models\DTO\UserRegister\UserRegisterDTOFactoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site1\Api\Services\RequestInterface::class,
        $container->get(\Romchik38\Site1\Services\Http\Request::class)
    );
    $container->add(\Romchik38\Server\Api\Services\Request\Http\RequestInterface::class,
        $container->get(\Romchik38\Site1\Api\Services\RequestInterface::class)
    );

    // REDIRECT
    $container->add(
        Romchik38\Server\Services\Redirect\Http\Redirect::class,
        function ($container) {
            return new Romchik38\Server\Services\Redirect\Http\Redirect(
                $container->get(\Romchik38\Site1\Models\Sql\Redirect\RedirectRepository::class),
                $container->get(\Romchik38\Server\Api\Models\DTO\RedirectResult\Http\RedirectResultDTOFactoryInterface::class),
                $container->get(\Romchik38\Server\Api\Services\Request\Http\RequestInterface::class)
            );
        }
    );

    $container->add(
        \Romchik38\Server\Api\Services\Redirect\Http\RedirectInterface::class,
        $container->get(Romchik38\Server\Services\Redirect\Http\Redirect::class)
    );

    return $container;
};
