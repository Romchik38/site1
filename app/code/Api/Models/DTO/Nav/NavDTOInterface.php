<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Nav;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface NavDTOInterface extends DTOInterface
{
    /** used to get an id from entity model */
    const NAV_MENU_ID_FIELD = 'nav_menu_id';

    public function getLinks();
}
