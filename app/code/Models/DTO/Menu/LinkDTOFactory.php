<?php

namespace Romchik38\Site1\Models\DTO\Menu;

use Romchik38\Site1\Api\Models\DTO\Menu\LinkDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Menu\LinkDTOInterface;

/**
 * Create a menu dto entity with provided values
 */
class LinkDTOFactory implements LinkDTOFactoryInterface
{
    public function create(string $description, string $name, string $url): LinkDTOInterface
    {
        return new LinkDTO($description, $name, $url);
    }
}
