<?php

namespace Romchik38\Site1\Models\DTO\Menu;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\Menu\LinkDTOInterface;
use Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkInterface;

/**
 * Represents an entity, used in view.
 * It's a menu element 
 */
class LinkDTO extends DTO implements LinkDTOInterface
{

    public function __construct(
        string $description,
        string $name,
        string $url,
        int $menuId,
        int $linkId,
        int $parentLinkId,
        int $priority,
        protected array $children = []
    ) {
        $this->data[VirtualLinkInterface::DESCRIPTION_FIELD] = $description;
        $this->data[VirtualLinkInterface::NAME_FIELD] = $name;
        $this->data[VirtualLinkInterface::URL_FIELD] = $url;
        $this->data[VirtualLinkInterface::MENU_ID_FIELD] = $menuId;
        $this->data[VirtualLinkInterface::LINK_ID_FIELD] = $linkId;
        $this->data[VirtualLinkInterface::PARENT_LINK_ID_FIELD] = $parentLinkId;
        $this->data[VirtualLinkInterface::PRIORITY_FIELD] = $priority;
    }

    public function getDescription(): string
    {
        return $this->data[VirtualLinkInterface::DESCRIPTION_FIELD];
    }

    public function getName(): string
    {
        return $this->data[VirtualLinkInterface::NAME_FIELD];
    }

    public function getUrl(): string
    {
        return $this->data[VirtualLinkInterface::URL_FIELD];
    }

    public function getMenuId(): int
    {
        return $this->data[VirtualLinkInterface::MENU_ID_FIELD];
    }

    public function getLinkId(): int
    {
        return $this->data[VirtualLinkInterface::LINK_ID_FIELD];
    }

    public function getParentLinkId(): int
    {
        return $this->data[VirtualLinkInterface::PARENT_LINK_ID_FIELD];
    }

    public function getPriority(): int
    {
        return $this->data[VirtualLinkInterface::PRIORITY_FIELD];
    }

    public function getChildrens(): array
    {
        return $this->children;
    }
}
