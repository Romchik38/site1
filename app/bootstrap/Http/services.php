<?php

declare(strict_types=1);

return function ($container) {
    // REQUEST
    $container->add(
        \Romchik38\Site1\Services\Http\Request::class,
        new \Romchik38\Site1\Services\Http\Request(
            $container->get(\Romchik38\Site1\Models\DTO\UserRegisterDTOFactory::class)
        )
    );

    $container->add(
        \Romchik38\Site1\Api\Services\RequestInterface::class,
        $container->get(\Romchik38\Site1\Services\Http\Request::class)
    );

    // REDIRECT
    $container->add(
        Romchik38\Server\Services\Redirect\Http\Redirect::class,
        function ($container) {
            return new Romchik38\Server\Services\Redirect\Http\Redirect(
                $container->get(\Romchik38\Site1\Models\Sql\Redirect\RedirectRepository::class)
            );
        }
    );

    $container->add(
        \Romchik38\Server\Api\Services\RedirectInterface::class,
        $container->get(Romchik38\Server\Services\Redirect\Http\Redirect::class)
    );

    return $container;
};
