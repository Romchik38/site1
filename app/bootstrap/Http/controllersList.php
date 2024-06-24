<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\controllersList;

use Romchik38\Server\Api\Results\RouterResultInterface;

$get = 'GET';
$post = 'POST';

// [method, route, class_name, callback with router result
return [
    [$get, '/', \Romchik38\Site1\Controllers\Main\Index::class, null],
    [$get, '/login', \Romchik38\Site1\Controllers\Login\Index::class, null],
    [$post, '/auth', \Romchik38\Site1\Controllers\Auth\Index::class, 
        function(RouterResultInterface $result, string $action = 'index'){
            $arr = [
                'index' => '/login/index?message=' . $result->getResponse(),
                'logout' => '/login/index?message=' . $result->getResponse(),
                'register' => '/login/register?message=' . $result->getResponse(),
            ];
            $url = $arr[$action];
            $result->setHeaders([                   
                [
                'Location: ' . $_SERVER['REQUEST_SCHEME'] . '://'
                    . $_SERVER['HTTP_HOST'] . $url, true, 301
            ]]);
    }]
];