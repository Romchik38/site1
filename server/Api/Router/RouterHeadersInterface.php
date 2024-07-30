<?php

namespace Romchik38\Server\Api\Router;

use Romchik38\Server\Api\Results\Http\RouterResultInterface;

interface RouterHeadersInterface {
    public function setHeaders(RouterResultInterface $result, string $action): void;
}