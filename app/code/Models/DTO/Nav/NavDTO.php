<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Nav;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Nav\NavDTOInterface;

class NavDTO extends DTO implements NavDTOInterface
{
    public function __construct(
        MenuDTOInterface $menuDTO
    ) {
        $this->data[NavDTOInterface::NAV_MENU_DTO_FIELD] = $menuDTO;
    }

    public function getMenuDTO(): MenuDTOInterface
    {
        return $this->data[NavDTOInterface::NAV_MENU_DTO_FIELD];
    }
}
