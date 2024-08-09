<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Virtual\Link;

use Romchik38\Server\Models\Model;
use Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkInterface;

class VirtualLink extends Model implements VirtualLinkInterface
{
    public function getDescription(): string
    {
        return $this->data[VirtualLinkInterface::DESCRIPTION_FIELD];
    }

    public function getLinkId(): int
    {
        return (int)$this->data[VirtualLinkInterface::LINK_ID_FIELD];
    }

    public function getMenuId(): int
    {
        return (int)$this->data[VirtualLinkInterface::MENU_ID_FIELD];
    }

    public function getName(): string
    {
        return $this->data[VirtualLinkInterface::NAME_FIELD];
    }

    public function getParentLinkId(): int
    {
        return (int)$this->data[VirtualLinkInterface::PARENT_LINK_ID_FIELD];
    }

    public function getPriority(): int
    {
        return (int)$this->data[VirtualLinkInterface::PRIORITY_FIELD];
    }

    public function getUrl(): string
    {
        return $this->data[VirtualLinkInterface::URL_FIELD];
    }
}
