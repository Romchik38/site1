<?php

namespace Romchik38\Site1\Router\Http\RouterHeaders;

use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Routers\Http\RouterHeader;
use Romchik38\Site1\Controllers\Login\Message;

class Auth extends RouterHeader {
    public function setHeaders(HttpRouterResultInterface $result, array $path): void
    {
        $action = $path[count($path) - 1];
        $encodedMessage = urlencode($result->getResponse());
        $arr = [
            'index' => '/login/index?' . Message::FIELD . '=' . $encodedMessage,
            'logout' => '/login/index?' . Message::FIELD . '=' . $encodedMessage,
            'register' => '/login/register?' . Message::FIELD . '=' . $encodedMessage,
            'recovery' => '/login/recovery?' . Message::FIELD . '=' . $encodedMessage,
            'changepassword' => '/login/index?' . Message::FIELD . '=' . $encodedMessage,
        ];
        $url = $arr[$action] ?? '';
        if ($url !== '') {
            $result->setHeaders([
                [
                    'Location: ' . $_SERVER['REQUEST_SCHEME'] . '://'
                        . $_SERVER['HTTP_HOST'] . $url, true, 301
                ]
            ]);
        }
    }
}