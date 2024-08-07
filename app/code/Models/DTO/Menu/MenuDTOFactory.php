<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Menu;

use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;

class MenuDTOFactory implements MenuDTOFactoryInterface
{
    public function create(
        int $id,
        string $name,
        array $links
    ): MenuDTOInterface {
        return new MenuDTO($id, $name, $links);
    }
}
