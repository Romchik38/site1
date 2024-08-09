<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Nav;

use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Nav\NavDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Nav\NavDTOInterface;

class NavDTOFactory implements NavDTOFactoryInterface
{
    public function create(MenuDTOInterface $menuDTO): NavDTOInterface
    {
        return new NavDTO($menuDTO);
    }
}
