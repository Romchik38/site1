<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\MenuToLinks;

use Romchik38\Server\Api\Models\CompositeId\CompositeIdModelInterface;

interface MenuToLinksInterface extends CompositeIdModelInterface
{
    const MENU_ID_FIELD = 'menu_id';
    const LINK_ID_FIELD = 'link_id';
    const PARENT_LINK_ID_FIELD = 'parent_link_id';
    const PRIORITY_FIELD = 'priority';

    public function getMenuId(): int;
    public function getLinkId(): int;
    public function getParentLinkId(): int;
    public function getPriority(): int;

    public function setMenuId(int $id): MenuToLinksInterface;
    public function setLinkId(int $id): MenuToLinksInterface;
    public function setParentLinkId(int $id): MenuToLinksInterface;
    public function setPriority(string $priority): MenuToLinksInterface;

}
