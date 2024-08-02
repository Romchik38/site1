<?php

declare(strict_types=1);

/**
 * A bootstrap file.
 * 
 * Classes features: 
 *   - do not have dependencies or they are primitive
 *   - used in other classes as dependencies
 * 
 */

return function ($container) {

    // FACTORIES
    $container->add(
        \Romchik38\Server\Models\EntityFactory::class,
        new Romchik38\Server\Models\EntityFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Models\Entity\EntityFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\EntityFactory::class)
    );
    
    $container->add(
        \Romchik38\Site1\Models\Menu\MenuModelFactory::class,
        new \Romchik38\Site1\Models\Menu\MenuModelFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\Menu\MenuModelFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Menu\MenuModelFactory::class)
    );

    // DTO
    $container->add(
        \Romchik38\Site1\Models\DTO\Login\LoginDTOFactory::class,
        new Romchik38\Site1\Models\DTO\Login\LoginDTOFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\DTO\Login\LoginDTOFactory::class)
    );

    $container->add(
        \Romchik38\Site1\Models\DTO\Main\MainDTOFactory::class,
        new Romchik38\Site1\Models\DTO\Main\MainDTOFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\DTO\Main\MainDTOFactory::class)
    );

    $container->add(
        \Romchik38\Site1\Models\DTO\UserRegisterDTOFactory::class,
        new Romchik38\Site1\Models\DTO\UserRegisterDTOFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\DTO\UserRegister\UserRegisterDTOFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\DTO\UserRegisterDTOFactory::class)
    );

    $container->add(
        \Romchik38\Server\Models\DTO\Email\EmailDTOFactory::class,
        new Romchik38\Server\Models\DTO\Email\EmailDTOFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\Email\EmailDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\Email\EmailDTOFactory::class)
    );

    $container->add(
        \Romchik38\Site1\Models\DTO\Header\HeaderDTOFactory::class,
        new \Romchik38\Site1\Models\DTO\Header\HeaderDTOFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\DTO\Header\HeaderDTOFactory::class)
    );

    $container->add(
        \Romchik38\Site1\Models\DTO\Footer\FooterDTOFactory::class,
        new \Romchik38\Site1\Models\DTO\Footer\FooterDTOFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\DTO\Footer\FooterDTOFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\DTO\Footer\FooterDTOFactory::class)
    );

    // SERVICES
    $container->add(
        \Romchik38\Server\Services\Mailer\PhpMail::class,
        new \Romchik38\Server\Services\Mailer\PhpMail()
    );

    $container->add(
        \Romchik38\Server\Api\Services\MailerInterface::class,
        $container->get(\Romchik38\Server\Services\Mailer\PhpMail::class)
    );


    return $container;
};
