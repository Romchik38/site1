<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Routers\DefaultRouter;
use Romchik38\Server\Results\DefaultRouterResult;
use Romchik38\Server\Api\Server;
use Romchik38\Server\Models\DTO\Email\EmailDTOFactory;
use Romchik38\Site1\Stubs\EchoLogger;

$container = new Container();

// MODELS
$models = require_once(__DIR__ . '/bootstrap/models.php');
$models($container);

// SERVICES 
$container->add(\Romchik38\Server\Services\Session::class,
    new \Romchik38\Server\Services\Session()
);

$container->add(
    \Romchik38\Server\Services\Mailer\PhpMail::class, 
    new \Romchik38\Server\Services\Mailer\PhpMail()
);

$container->add(\Romchik38\Site1\Services\Http\Request::class,
    new \Romchik38\Site1\Services\Http\Request(
        $container->get(\Romchik38\Site1\Models\DTO\UserRegisterDTOFactory::class)
    )
);

$container->add(\Romchik38\Site1\Services\PasswordCheck::class,
    new \Romchik38\Site1\Services\PasswordCheck(
        $container->get(\Romchik38\Site1\Models\Sql\User\UserRepository::class)
    )
);

$container->add(\Romchik38\Site1\Services\UserRegister::class,
    new \Romchik38\Site1\Services\UserRegister(
        $container->get(\Romchik38\Site1\Models\Sql\User\UserRepository::class)
    )
);

$container->add(\Romchik38\Site1\Services\UserRecoveryEmail::class,
    new \Romchik38\Site1\Services\UserRecoveryEmail(
        $container->get(\Romchik38\Server\Models\Sql\Entity\EntityRepository::class),
        1,
        'email_contact_recovery',
        $container->get(EmailDTOFactory::class),
        $container->get(\Romchik38\Server\Services\Mailer\PhpMail::class),
        $container->get(\Romchik38\Site1\Models\Sql\RecoveryEmail\RecoveryEmailRepository::class)
    )
);

$container->add(
    \Romchik38\Server\Services\Redirect::class, 
    function($container){
        return new \Romchik38\Server\Services\Redirect(
            $container->get(\Romchik38\Site1\Models\Sql\Redirect\RedirectRepository::class)
        );
    }
);

// VIEWS
$views = require_once(__DIR__ . '/code/Views/Html/views.php');
$views($container);

// CONTROLLERS
$controllers = require_once(__DIR__ . '/bootstrap/Http/controllers.php');
$controllers($container);

// ROUTER
$container->add(DefaultRouterResult::class, new DefaultRouterResult(
    /** default response, headers, statusCode */
));
$controllersList = require_once(__DIR__ . '/bootstrap/Http/controllersList.php');
$container->add(
    DefaultRouter::class, new DefaultRouter(
            $container->get(DefaultRouterResult::class),
            $controllersList,
            $container,
            null,
            $container->get(Romchik38\Server\Services\Redirect::class)
    )
);

// SERVER
$container->add(Server::CONTAINER_LOGGER_FILED, new EchoLogger());

return $container;
