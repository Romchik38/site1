<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\MenuToLinks;

use Romchik38\Server\Models\CompositeId\CompositeIdModel;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksInterface;

class MenuToLinks extends CompositeIdModel implements MenuToLinksInterface
{

    public function getMenuId(): int {
        return $this->data[MenuToLinksInterface::MENU_ID_FIELD];
    }

    public function getLinkId(): int {
        return $this->data[MenuToLinksInterface::LINK_ID_FIELD];
    }

    public function getParentLinkId(): int {
        return $this->data[MenuToLinksInterface::PARENT_LINK_ID_FIELD];
    }

    public function getPriority(): int {
        return $this->data[MenuToLinksInterface::PRIORITY_FIELD];
    }

    public function setMenuId(int $id): MenuToLinksInterface {
        $this->data[MenuToLinksInterface::MENU_ID_FIELD] = $id;
        return $this;
    }

    public function setLinkId(int $id): MenuToLinksInterface {
        $this->data[MenuToLinksInterface::LINK_ID_FIELD] = $id;
        return $this;
    }

    public function setParentLinkId(int $id): MenuToLinksInterface {
        $this->data[MenuToLinksInterface::PARENT_LINK_ID_FIELD] = $id;
        return $this;
    }

    public function setPriority(string $priority): MenuToLinksInterface {
        $this->data[MenuToLinksInterface::PRIORITY_FIELD] = $priority;
        return $this;
    }
}
