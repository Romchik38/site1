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

// Start app
$server->run();
$server->log();   // write all logs at the time, if they didn't send earlier
// End app

//test
// use Psr\Log\LoggerInterface;
// use Psr\Log\LogLevel;
/** @var LoggerInterface $logger */
// $logger = $container->get(Server::CONTAINER_LOGGER_FIELD);
// $logger->log(LogLevel::ERROR, 'some error from index');
// $server->log();