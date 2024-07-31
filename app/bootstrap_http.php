<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Server;

$container = new Container();

// No dependencies
$no_dependencies = require_once(__DIR__ . '/bootstrap/no_dependencies.php');
$no_dependencies($container);

$http_no_dependencies = require_once(__DIR__ . '/bootstrap/Http/no_dependencies.php');
$http_no_dependencies($container);

// MODELS
$models_no_dependencies = require_once(__DIR__ . '/bootstrap/Sql/no_dependencies.php');
$models_no_dependencies($container);

$models = require_once(__DIR__ . '/bootstrap/Sql/models.php');
$models($container);

// SERVICES 
$services = require_once(__DIR__ . '/bootstrap/services.php');
$services($container);

$servicesHttp = require_once(__DIR__ . '/bootstrap/Http/services.php');
$servicesHttp($container);

// VIEWS
$views = require_once(__DIR__ . '/code/Views/Html/views.php');
$views($container);

// CONTROLLERS
$controllers = require_once(__DIR__ . '/bootstrap/controllers.php');
$controllers($container);

// ROUTER
$router = require_once(__DIR__ . '/bootstrap/Http/router.php');
$router($container);

// ROUTER HEADERS
$headers = require_once(__DIR__ . '/bootstrap/Http/router_headers.php');
$headers($container);

// SERVER
$server = require_once(__DIR__ . '/bootstrap/Http/server.php');
$server($container);

return $container;
