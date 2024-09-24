<?php

declare(strict_types=1);

namespace Romchik38\Site1\Router\Http\RouterHeaders\Api;

use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Routers\Http\RouterHeader;

class Userinfo extends RouterHeader {
    public function setHeaders(HttpRouterResultInterface $result, array $path): void {
        $result->setHeaders([
            ['Content-Type: application/json']
        ]);  
    }
}