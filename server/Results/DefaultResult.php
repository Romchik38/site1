<?php

declare(strict_types=1);

namespace Romchik38\Server\Results;

use Romchik38\Server\Api\ResultInterface;

class DefaultResult implements ResultInterface
{
    public function __construct(
        protected string $response = ResultInterface::DEFAULT_RESPONSE,
        protected array $headers = ResultInterface::DEFAULT_HEADERS,
        protected int $statusCode = ResultInterface::DEFAULT_STATUS_CODE,
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

    public function setResponse(string $response): ResultInterface
    {
        $this->response = $response;
        return $this;
    }

    public function setHeaders(array $headers): ResultInterface
    {
        $this->headers = $headers;
        return $this;
    }
    public function setStatusCode(int $statusCode): ResultInterface
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
