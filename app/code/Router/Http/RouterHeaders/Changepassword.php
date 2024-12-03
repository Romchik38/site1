<?php

namespace Romchik38\Site1\Router\Http\RouterHeaders;

use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Routers\Http\RouterHeader;
use Romchik38\Site1\Controllers\Login\Message;

class Changepassword extends RouterHeader
{
    public function setHeaders(HttpRouterResultInterface $result, array $path): void
    {
        $encodedMessage = urlencode($result->getResponse());
        $url = '/login/changepassword?' . Message::FIELD . '=' . $encodedMessage;
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
