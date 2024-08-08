<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\Virtual;

use Romchik38\Server\Api\Models\ModelInterface;

interface VirtualRepositoryInterface
{
    /** 
     * @return ModelInterface[]
     */
    public function list(string $expression, array $params): array;
}
