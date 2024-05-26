<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Romchik38\Server\DefaultServer;

$container = require_once __DIR__ . '/../app/bootstrap.php';

$server = new DefaultServer($container);

$server->run();