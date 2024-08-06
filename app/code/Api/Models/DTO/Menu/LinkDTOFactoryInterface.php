<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Menu;

/**
 * Create a menu dto entity with provided values
 */
interface LinkDTOFactoryInterface
{
    public function create(
        string $description,
        string $name,
        string $url
    ): LinkDTOInterface;
}
