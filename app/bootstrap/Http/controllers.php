<?php

declare(strict_types=1);

return function ($container) {
    // /
    $container->add(
        \Romchik38\Site1\Controllers\Main\Index::class, 
        function($container){
            return new \Romchik38\Site1\Controllers\Main\Index(
                $container->get(\Romchik38\Site1\Views\Html\Classes\Main\Index::class),
                $container->get(\Romchik38\Site1\Models\Sql\Page\PageRepository::class),
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
                $container->get(\Romchik38\Server\Services\Session::class),
                $container->get(\Romchik38\Site1\Models\DTO\Login\LoginDTOFactory::class),
                $container->get(\Romchik38\Site1\Services\Http\Request::class),
                $container->get(\Romchik38\Site1\Models\Sql\User\UserRepository::class)
            );
        }
    );

    // /auth
    $container->add(
        \Romchik38\Site1\Controllers\Auth\Index::class,
        function($container){
            return new \Romchik38\Site1\Controllers\Auth\Index(
                $container->get(\Romchik38\Site1\Services\Http\Request::class),
                $container->get(\Romchik38\Site1\Services\PasswordCheck::class),
                $container->get(\Romchik38\Server\Services\Session::class),
                $container->get(\Romchik38\Site1\Services\UserRegister::class),
                $container->get(\Romchik38\Site1\Services\UserRecoveryEmail::class),
                $container->get(\Romchik38\Site1\Models\Sql\User\UserRepository::class)
            );
        }
    );

    // /changepassword
    $container->add(
        Romchik38\Site1\Controllers\Changepassword\Index::class,
        new Romchik38\Site1\Controllers\Changepassword\Index(
            $container->get(\Romchik38\Site1\Services\Http\Request::class),
            $container->get(\Romchik38\Site1\Services\UserRecoveryEmail::class),
            $container->get(\Romchik38\Server\Services\Session::class),
            $container->get(\Romchik38\Site1\Models\Sql\User\UserRepository::class),
            $container->get(\Romchik38\Server\Services\Logger\Loggers\FileLogger::class)
        )
    );
    
    return $container;
};