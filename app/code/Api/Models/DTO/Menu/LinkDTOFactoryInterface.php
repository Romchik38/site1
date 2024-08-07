<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Menu;

/**
 * Creates a link dto entity with provided values
 */
interface LinkDTOFactoryInterface
{
    public function create(
        string $description,
        string $name,
        string $url,
        int $menuId,
        int $linkId,
        int $parentLinkId,
        int $priority,
        array $children
    ): LinkDTOInterface;
}
