<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Api;

interface ApiDTOFactoryInterface
{
    public function create(mixed $result, string $status): ApiDTOInterface;
}
