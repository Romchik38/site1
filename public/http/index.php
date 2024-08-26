<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

$container = require_once __DIR__ . '/../../app/bootstrap_http.php';

$server = $container->get(\Romchik38\Server\Api\Servers\ServerInterface::class);

/* 
* At this place can be filter or something else
*
* $server->filter()
* ...
* ...
*/

// Start app
$server->run()->log();
// End app

//test
// use Psr\Log\LoggerInterface;
// use Psr\Log\LogLevel;
/** @var LoggerInterface $logger */
// $logger = $container->get(Psr\Log\LoggerInterface::class);
// $logger->log(LogLevel::ERROR, 'some error from index');
// $server->log();