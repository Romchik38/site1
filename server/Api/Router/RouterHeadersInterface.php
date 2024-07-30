<?php

namespace Romchik38\Server\Api\Router;

use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;

interface RouterHeadersInterface {
    public function setHeaders(HttpRouterResultInterface $result, string $action): void;
}