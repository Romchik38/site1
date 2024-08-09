<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Nav;

use Romchik38\Server\Api\Models\DTO\DTOInterface;
use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;

interface NavDTOInterface extends DTOInterface
{
    /** used to get an id from entity model */
    const NAV_MENU_ID_FIELD = 'nav_menu_id';
    /** used to get data from dto */
    const NAV_MENU_DTO_FIELD = 'nav_menu_dto';

    public function getMenuDTO(): MenuDTOInterface;
}
