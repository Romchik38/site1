<?php

namespace Romchik38\Site1\Router\Http\RouterHeaders;

use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Routers\Http\RouterHeader;
use Romchik38\Site1\Api\Services\RequestInterface;

class Auth extends RouterHeader {
    public function setHeaders(HttpRouterResultInterface $result, array $path): void
    {
        $action = $path[count($path) - 1];
        $encodedMessage = urlencode($result->getResponse());
        $arr = [
            'index' => '/login/index?' . RequestInterface::MESSAGE_FIELD . '=' . $encodedMessage,
            'logout' => '/login/index?' . RequestInterface::MESSAGE_FIELD . '=' . $encodedMessage,
            'register' => '/login/register?' . RequestInterface::MESSAGE_FIELD . '=' . $encodedMessage,
            'recovery' => '/login/recovery?' . RequestInterface::MESSAGE_FIELD . '=' . $encodedMessage,
            'changepassword' => '/login/index?' . RequestInterface::MESSAGE_FIELD . '=' . $encodedMessage,
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