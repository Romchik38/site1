<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Model;

interface DatabaseInterface
{
    public function queryParams(string $query, array $params): array;
}
