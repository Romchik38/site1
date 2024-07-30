<?php

declare(strict_types=1);

namespace Romchik38\Server\Results\Http;

use Romchik38\Server\Api\Results\Http\RouterResultInterface;

class DefaultRouterResult implements RouterResultInterface
{
    public function __construct(
        protected string $response = RouterResultInterface::DEFAULT_RESPONSE,
        protected array $headers = RouterResultInterface::DEFAULT_HEADERS,
        protected int $statusCode = RouterResultInterface::DEFAULT_STATUS_CODE,
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

    public function setResponse(string $response): RouterResultInterface
    {
        $this->response = $response;
        return $this;
    }

    public function setHeaders(array $headers): RouterResultInterface
    {
        $this->headers = $headers;
        return $this;
    }
    public function setStatusCode(int $statusCode): RouterResultInterface
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
