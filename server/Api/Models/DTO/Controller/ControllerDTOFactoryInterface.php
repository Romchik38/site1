<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Controller;

interface ControllerDTOFactoryInterface
{
    public function create(
        string $name,
        array $pathVar,
        array $childrenVar
    ): ControllerDTOInterface;
}
