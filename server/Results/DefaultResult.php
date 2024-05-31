<?php

declare(strict_types=1);

namespace Romchik38\Server\Results;

use Romchik38\Server\Api\Result;

class DefaultResult implements Result
{
    public function __construct(
        protected string $response = Result::DEFAULT_RESPONSE,
        protected array $headers = Result::DEFAULT_HEADERS,
        protected int $statusCode = Result::DEFAULT_STATUS_CODE,
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

    public function setResponse(string $response): Result
    {
        $this->response = $response;
        return $this;
    }

    public function setHeaders(array $headers): Result
    {
        $this->headers = $headers;
        return $this;
    }
    public function setStatusCode(int $statusCode): Result
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
