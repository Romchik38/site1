<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

interface Result {
    const DEFAULT_RESPONSE = '';
    const DEFAULT_HEADERS = [];
    const DEFAULT_STATUS_CODE = 0;

    public function getResponse(): string;
    public function getHeaders(): array;
    public function getStatusCode(): int;

    public function setResponse(string $response): Result;
    public function setHeaders(array $headers): Result;
    public function setStatusCode(int $statusCode): Result;
}