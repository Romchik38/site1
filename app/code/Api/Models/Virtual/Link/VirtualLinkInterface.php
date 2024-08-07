<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\Virtual\Link;

use Romchik38\Server\Api\Models\ModelInterface;

interface VirtualLinkInterface extends ModelInterface
{
    const DESCRIPTION_FIELD = 'description';
    const LINK_ID_FIELD = 'link_id';
    const MENU_ID_FIELD = 'menu_id';
    const NAME_FIELD = 'name';
    const PARENT_LINK_ID_FIELD = 'parent_link_id';
    const PRIORITY_FIELD = 'priority';
    const URL_FIELD = 'url';

    public function getDescription(): string;
    public function getLinkId(): int; 
    public function getMenuId(): int;    
    public function getName(): string;
    public function getParentLinkId(): int;
    public function getPriority(): int;
    public function getUrl(): string;
}
