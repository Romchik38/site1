<?php

namespace Romchik38\Site1\Router\Http\RouterHeaders;

use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Api\Router\Http\RouterHeadersInterface;
use Romchik38\Site1\Api\Services\RequestInterface;

class Changepassword implements RouterHeadersInterface
{
    public function setHeaders(HttpRouterResultInterface $result, array $path): void
    {
        $encodedMessage = urlencode($result->getResponse());
        $url = '/login/changepassword?' . RequestInterface::MESSAGE_FIELD . '=' . $encodedMessage;
        $result->setHeaders([
            [
                'Location: ' . $_SERVER['REQUEST_SCHEME'] . '://'
                    . $_SERVER['HTTP_HOST'] . $url,
                true,
                301
            ]
        ]);
    }
}
