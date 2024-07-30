<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\controllersList;

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
        \Romchik38\Site1\Router\Http\RouterHeaders\Auth::class
    ],

    [
        $get, '/changepassword', \Romchik38\Site1\Controllers\Changepassword\Index::class,
        \Romchik38\Site1\Router\Http\RouterHeaders\Changepassword::class
    ]
];
