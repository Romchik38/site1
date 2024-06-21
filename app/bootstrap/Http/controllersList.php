<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\controllersList;

$get = 'GET';
$post = 'POST';

return [
    [$get, '/', \Romchik38\Site1\Controllers\Main\Index::class],
    [$get, '/login', \Romchik38\Site1\Controllers\Login\Index::class],
    [$post, '/auth', \Romchik38\Site1\Controllers\Auth\Index::class]
];