<?php

declare(strict_types=1);

/**
 * This is Romchik38 example site1
 * 
 * It demonstrates many features. See readme.md and doc/ folder
 */
require_once __DIR__ . '/../../vendor/autoload.php';

/** 
 * Init section
 * 
 * */
try{
    $container = (require_once __DIR__ . '/../../app/bootstrap_http.php')();
} catch(Exception $e) {
    error_log($e->getMessage());
    exit(1);
}
/** init section end */


$server = $container->get(\Romchik38\Server\Api\Servers\Http\HttpServerInterface::class);

/* 
* Upcoming features section
*
* $server->filter()
* ...
*/

 /**
 * Execute section
 * 
 * All RuntimeExceptions are catched and logged. 
 * User see a server error page based on a primary design
 */

$server->run()->log();
/** Execute section end */