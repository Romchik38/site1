<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\controllersList;

use Romchik38\Server\Api\Results\RouterResultInterface;
use Romchik38\Site1\Api\Services\RequestInterface;

$get = 'GET';
$post = 'POST';

// [method, route, class_name, header class
return [
    [$get, '/', \Romchik38\Site1\Controllers\Main\Index::class, ''],
    [$get, '/login', \Romchik38\Site1\Controllers\Login\Index::class, ''],
    [
        $post, 
        '/auth', 
        \Romchik38\Site1\Controllers\Auth\Index::class,
        \Romchik38\Site1\Http\Router\RouterHeaders\Auth::class
    ],

    [
        $get, '/changepassword', \Romchik38\Site1\Controllers\Changepassword\Index::class,
        \Romchik38\Site1\Http\Router\RouterHeaders\Changepassword::class
    ]
];
