<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

interface Result {
    const DEFAULT_RESPONSE = '404 Error - Page not found';
    const DEFAULT_HEADERS = [];
    const DEFAULT_STATUS_CODE = 404;

    public function getResponse(): string;
    public function getHeaders(): array;
    public function getStatusCode(): int;

    public function setResponse(string $response): void;
    public function setHeaders(array $headers): void;
    public function setStatusCode(int $statusCode): void;
}