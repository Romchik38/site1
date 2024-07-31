<?php

declare(strict_types=1);

use Romchik38\Container;

/**
 * A bootstrap file.
 * 
 * Classes features: 
 *   - do not have dependencies or they are primitive
 *   - used in other classes as dependencies
 * 
 */

 return function ($container) {
    $configDatabase = require_once(__DIR__ . '/../config/database.php');

    // DATABASES
    $container->add(
        \Romchik38\Server\Models\Sql\DatabasePostgresql::class,
        new Romchik38\Server\Models\Sql\DatabasePostgresql($configDatabase)
    );
    
    $container->add(
        \Romchik38\Server\Api\Models\DatabaseInterface::class,
        $container->get(\Romchik38\Server\Models\Sql\DatabasePostgresql::class)
    );

    // FACTORIES
    $container->add(
        \Romchik38\Site1\Models\Sql\Page\PageFactory::class,
        new Romchik38\Site1\Models\Sql\Page\PageFactory()
    );

    $container->add(
        \Romchik38\Site1\Models\Sql\Redirect\RedirectFactory::class,
        new Romchik38\Site1\Models\Sql\Redirect\RedirectFactory()
    );

    $container->add(
        \Romchik38\Site1\Models\Sql\User\UserFactory::class,
        new Romchik38\Site1\Models\Sql\User\UserFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\User\UserFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\User\UserFactory::class)
    );

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
        \Romchik38\Server\Models\EntityFactory::class,
        new Romchik38\Server\Models\EntityFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Models\Entity\EntityFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\EntityFactory::class)
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
        \Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailFactory::class,
        new Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailFactory::class)
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