<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\MenuToLinks;

use Romchik38\Server\Api\Models\CompositeId\CompositeIdDTOInterface;

/** Used in repository getById method */
interface MenuToLinksIdDTOInterface extends CompositeIdDTOInterface
{
    const MENU_ID_FIELD = MenuToLinksInterface::MENU_ID_FIELD;
    const LINK_ID_FIELD = MenuToLinksInterface::LINK_ID_FIELD;
    const PARRENT_LINK_ID_FIELD = MenuToLinksInterface::PARRENT_LINK_ID_FIELD;

    const ID_KEYS = [
        MenuToLinksInterface::MENU_ID_FIELD, 
        MenuToLinksInterface::LINK_ID_FIELD,
        MenuToLinksInterface::PARRENT_LINK_ID_FIELD
    ];

}
