<?php

namespace Romchik38\Site1\Router\Http\RouterHeaders;

use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Api\Router\Http\RouterHeadersInterface;
use Romchik38\Site1\Api\Services\RequestInterface;

class Changepassword implements RouterHeadersInterface {
    public function setHeaders(HttpRouterResultInterface $result, string $action): void
    {
        $encodedMessage = urlencode($result->getResponse());
        $arr = [
            'index' => '/login/changepassword?' . RequestInterface::MESSAGE_FIELD . '=' . $encodedMessage
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