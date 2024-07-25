<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\controllersList;

use Romchik38\Server\Api\Results\RouterResultInterface;
use Romchik38\Site1\Api\Services\RequestInterface;

$get = 'GET';
$post = 'POST';

// [method, route, class_name, callback with router result
return [
    [$get, '/', \Romchik38\Site1\Controllers\Main\Index::class, null],
    [$get, '/login', \Romchik38\Site1\Controllers\Login\Index::class, null],
    [
        $post, '/auth', \Romchik38\Site1\Controllers\Auth\Index::class,
        function (RouterResultInterface $result, string $action = 'index') {
            $encodedMessage = urlencode($result->getResponse());
            $arr = [
                'index' => '/login/index?' . RequestInterface::MESSAGE_FIELD . '=' . $encodedMessage,
                'logout' => '/login/index?' . RequestInterface::MESSAGE_FIELD . '=' . $encodedMessage,
                'register' => '/login/register?' . RequestInterface::MESSAGE_FIELD . '=' . $encodedMessage,
                'recovery' => '/login/recovery?' . RequestInterface::MESSAGE_FIELD . '=' . $encodedMessage
            ];
            $url = $arr[$action] ?? $arr[$action];
            $result->setHeaders([
                [
                    'Location: ' . $_SERVER['REQUEST_SCHEME'] . '://'
                        . $_SERVER['HTTP_HOST'] . $url, true, 301
                ]
            ]);
        }
    ],

    [
        $get, '/changepassword', \Romchik38\Site1\Controllers\Changepassword\Index::class,
        null
    ]
];
