<?php

namespace Romchik38\Site1\Models\DTO\Menu;

use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;

/**
 * Create a menu dto entity with provided values
 */
class MenuDTOFactory implements MenuDTOFactoryInterface
{
    public function create(string $description, string $name, string $url): MenuDTOInterface
    {
        return new MenuDTO($description, $name, $url);
    }
}
