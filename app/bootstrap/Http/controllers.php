<?php

declare(strict_types=1);

return function ($container) {
    // /
    $container->add(
        \Romchik38\Site1\Controllers\Main\Index::class, 
        function($container){
            return new \Romchik38\Site1\Controllers\Main\Index(
                $container->get(\Romchik38\Site1\Views\Html\Classes\Main\Index::class),
                $container->get(\Romchik38\Site1\Api\Models\Page\PageRepositoryInterface::class),
                $container->get(\Romchik38\Site1\Models\DTO\Main\MainDTOFactory::class)
            );
        }
    );
    // /login
    $container->add(
        \Romchik38\Site1\Controllers\Login\Index::class, 
        function($container){
            return new \Romchik38\Site1\Controllers\Login\Index(
                $container->get(\Romchik38\Site1\Views\Html\Classes\Login\Index::class),
                $container->get(\Romchik38\Server\Api\Services\SessionInterface::class),
                $container->get(\Romchik38\Site1\Models\DTO\Login\LoginDTOFactory::class),
                $container->get(\Romchik38\Site1\Api\Services\RequestInterface::class),
                $container->get(\Romchik38\Site1\Api\Models\User\UserRepositoryInterface::class)
            );
        }
    );

    // /auth
    $container->add(
        \Romchik38\Site1\Controllers\Auth\Index::class,
        function($container){
            return new \Romchik38\Site1\Controllers\Auth\Index(
                $container->get(\Romchik38\Site1\Api\Services\RequestInterface::class),
                $container->get(\Romchik38\Site1\Api\Services\PasswordCheckInterface::class),
                $container->get(\Romchik38\Server\Api\Services\SessionInterface::class),
                $container->get(\Romchik38\Site1\Api\Services\UserRegisterInterface::class),
                $container->get(\Romchik38\Site1\Api\Services\UserRecoveryEmailInterface::class),
                $container->get(\Romchik38\Site1\Api\Models\User\UserRepositoryInterface::class)
            );
        }
    );

    // /changepassword
    $container->add(
        Romchik38\Site1\Controllers\Changepassword\Index::class,
        new Romchik38\Site1\Controllers\Changepassword\Index(
            $container->get(\Romchik38\Site1\Api\Services\RequestInterface::class),
            $container->get(\Romchik38\Site1\Api\Services\UserRecoveryEmailInterface::class),
            $container->get(\Romchik38\Server\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site1\Api\Models\User\UserRepositoryInterface::class),
            $container->get(\Psr\Log\LoggerInterface::class)
        )
    );
    
    return $container;
};