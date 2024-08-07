<?php

namespace Romchik38\Site1\Api\Models\Virtual\Link;

use Romchik38\Server\Api\Models\ModelInterface;

interface VirtualLinkInterface extends ModelInterface
{
    const DESCRIPTION_FIELD = 'description';
    const NAME_FIELD = 'name';
    const URL_FIELD = 'url';
    const MENU_ID_FIELD = 'menu_id';
    const LINK_ID_FIELD = 'link_id';
    const PARENT_LINK_ID_FIELD = 'parent_link_id';
    const PRIORITY_FIELD = 'priority';
}
