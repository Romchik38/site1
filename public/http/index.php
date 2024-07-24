<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Romchik38\Server\Servers\DefaultServer;
use Romchik38\Server\Api\Server;

$container = require_once __DIR__ . '/../../app/bootstrap_http.php';

$server = new DefaultServer(
    $container, 
    $container->get(Server::CONTAINER_LOGGER_FIELD)
);

/* 
* At this place can be filter or something else
*
* $server->filter()
* ...
* ...
*/

/** @var \Romchik38\Server\Services\Logger\Loggers\FileLogger $logger */
use Psr\Log\LogLevel;
$logger = $container->get(\Romchik38\Server\Services\Logger\Loggers\FileLogger::class);
$logger->log(LogLevel::DEBUG, 'hello from index');

// Start app
$server->run();
$server->log();
// End app