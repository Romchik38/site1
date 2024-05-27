<?php

declare(strict_types=1);

namespace Romchik38\Server\Results;

use Romchik38\Server\Api\RouterResult;

class DefaultRouterResult implements RouterResult
{
    public function getResponse(): string
    {
        return '';
    }
    public function getHeaders(): array
    {
        return [];
    }
    public function getStatusCode(): int
    {
        return 0;
    }
}
