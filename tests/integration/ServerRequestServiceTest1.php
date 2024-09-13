<?php

declare(strict_types=1);

include_once(__DIR__ . '/../../vendor/autoload.php');
/* run this test 
* php ServerRequestServiceTest1 < 'hello'
*/


use Romchik38\Server\Services\Request\Http\ServerRequestService;

$service = new ServerRequestService();

$result = $service->getBodyContent();

$a = 1;

