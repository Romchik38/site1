<?php

declare(strict_types=1);

return function ($container) {
    // REDIRECT
    $container->add(
        Romchik38\Server\Services\Redirect\Http\Redirect::class,
        function ($container) {
            return new Romchik38\Server\Services\Redirect\Http\Redirect(
                $container->get(\Romchik38\Site1\Models\Sql\Redirect\RedirectRepository::class),
                $container->get(\Romchik38\Server\Api\Models\DTO\RedirectResult\Http\RedirectResultDTOFactoryInterface::class),
                $container->get(\Psr\Http\Message\ServerRequestInterface::class)
            );
        }
    );
    $container->add(
        \Romchik38\Server\Api\Services\Redirect\Http\RedirectInterface::class,
        $container->get(Romchik38\Server\Services\Redirect\Http\Redirect::class)
    );

    return $container;
};
