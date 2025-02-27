<?php

declare(strict_types=1);

namespace Romchik38\Site1\Middlewares\Response;

use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Middleware\ResponseMiddlewareInterface;

final class ApiContentTypeJson implements ResponseMiddlewareInterface
{
    public function __invoke(ResponseInterface $response): ResponseInterface
    {
        $newResponse = $response;
        $contentTypes = $response->getHeader('Content-Type');
        $type = 'application/json';
        if (in_array($type, $contentTypes) === false) {
            $newResponse = $response->withAddedHeader('Content-Type', $type);
        }
        return $newResponse;
    }
}
