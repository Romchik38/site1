<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\DTO\Api;

use Romchik38\Server\Api\Models\DTO\Api\ApiDTOFactoryInterface;
use Romchik38\Server\Api\Models\DTO\Api\ApiDTOInterface;

class ApiDTOFactory implements ApiDTOFactoryInterface
{
    public function create(mixed $result, string $status): ApiDTOInterface
    {
        return new ApiDTO($result, $status);
    }
}
