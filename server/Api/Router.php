<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

use Romchik38\Server\Api\RouterResult;
use Romchik38\Server\Api\Controller;

interface Router
{
    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    
    public function addController(
        string $method,
        string $url,
        string $controller
    ): Router;
    public function execute(): RouterResult;
}
