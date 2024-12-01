<?php

declare(strict_types=1);

use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;

return function ($container) {
    
    // PASSWORDCHECK
    $container->add(
        \Romchik38\Site1\Application\UserPasswordCheck\PasswordCheckService::class,
        new \Romchik38\Site1\Application\UserPasswordCheck\PasswordCheckService(
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class)
        )
    );

    
    // USERREGISTER
    $container->add(
        \Romchik38\Site1\Application\UserRegister\UserRegisterService::class,
        new \Romchik38\Site1\Application\UserRegister\UserRegisterService(
            $container->get(\Romchik38\Site1\Domain\User\UserRepositoryInterface::class),
            $container->get(\Psr\Log\LoggerInterface::class)
        )
    );

    return $container;
};