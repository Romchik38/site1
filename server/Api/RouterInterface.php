<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

use Romchik38\Server\Api\Results\ResultInterface;

interface RouterInterface
{
    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    
    public function addController(
        string $method,
        string $url,
        string $controller,
        callable|null $callback
    ): RouterInterface;

    public function execute(): ResultInterface;
}
