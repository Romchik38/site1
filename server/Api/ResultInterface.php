<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

interface ResultInterface {
    const DEFAULT_RESPONSE = '';
    const DEFAULT_HEADERS = [];
    const DEFAULT_STATUS_CODE = 0;

    public function getResponse(): string;
    public function getHeaders(): array;
    public function getStatusCode(): int;

    public function setResponse(string $response): ResultInterface;
    public function setHeaders(array $headers): ResultInterface;
    public function setStatusCode(int $statusCode): ResultInterface;
}