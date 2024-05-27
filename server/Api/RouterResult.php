<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

interface RouterResult {
    public function getResponse(): string;
    public function getHeaders(): array;
    public function getStatusCode(): int;
}