<?php

declare(strict_types=1);

/**
 * A bootstrap file.
 * 
 * Classes features: 
 *   - do not have any dependencies or they are primitive
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

    $container->add(
        \Romchik38\Site1\Models\MenuLinks\MenuLinksFactory::class,
        new \Romchik38\Site1\Models\MenuLinks\MenuLinksFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\MenuLinks\MenuLinksFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\MenuLinks\MenuLinksFactory::class)
    );

    $container->add(
        \Romchik38\Site1\Models\Virtual\Link\VirtualLinkFactory::class,
        new \Romchik38\Site1\Models\Virtual\Link\VirtualLinkFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Virtual\Link\VirtualLinkFactory::class)
    );

    $container->add(
        \Romchik38\Site1\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelFactory::class,
        new \Romchik38\Site1\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelFactory()
    );
    $container->add(
        Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelFactory::class)
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

    $container->add(
        \Romchik38\Site1\Models\DTO\Menu\LinkDTOFactory::class,
        new \Romchik38\Site1\Models\DTO\Menu\LinkDTOFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\DTO\Menu\LinkDTOFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\DTO\Menu\LinkDTOFactory::class)
    );

    $container->add(
        \Romchik38\Site1\Models\DTO\Menu\MenuDTOFactory::class,
        new \Romchik38\Site1\Models\DTO\Menu\MenuDTOFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\DTO\Menu\MenuDTOFactory::class)
    );

    $container->add(
        \Romchik38\Site1\Models\DTO\Nav\NavDTOFactory::class,
        new \Romchik38\Site1\Models\DTO\Nav\NavDTOFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\DTO\Nav\NavDTOFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\DTO\Nav\NavDTOFactory::class)
    );
    
    $container->add(
        \Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTOFactory::class,
        new \Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTOFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTOFactory::class)
    );

    $container->add(
        \Romchik38\Site1\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOFactory::class,
        new \Romchik38\Site1\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOFactory()
    );
    $container->add(
        \Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOFactoryInterface::class,
        $container->get(\Romchik38\Site1\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOFactory::class)
    );

    $container->add(
        \Romchik38\Server\Models\DTO\Api\ApiDTOFactory::class,
        new \Romchik38\Server\Models\DTO\Api\ApiDTOFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\Api\ApiDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\Api\ApiDTOFactory::class)
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
