<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

interface RouterInterface
{
    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    
    public function addController(
        string $method,
        string $url,
        string $controller
    ): RouterInterface;

    public function execute(): ResultInterface;
}
