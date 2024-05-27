<?php

declare(strict_types=1);

namespace Romchik38\Server\Results;

use Romchik38\Server\Api\RouterResult;

class DefaultRouterResult implements RouterResult
{
    public function __construct(
        protected string $response = RouterResult::DEFAULT_RESPONSE,
        protected array $headers = RouterResult::DEFAULT_HEADERS,
        protected int $statusCode = RouterResult::DEFAULT_STATUS_CODE,
    )
    {
    }
    public function getResponse(): string
    {
        return $this->response;
    }
    public function getHeaders(): array
    {
        return $this->headers;
    }
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setResponse(string $response): void
    {
        $this->response = $response;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }
}
