<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Menu;

use Romchik38\Server\Api\Models\DTO\DTOInterface;
use Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkInterface;

/**
 * Represents an entity, used in a view.
 * It's a menu element 
 */
interface LinkDTOInterface extends DTOInterface
{

    /**
     * Fields in this DTO used from VirtualLinkInterface
     */

    // const DESCRIPTION = VirtualLinkInterface::DESCRIPTION;    << Moved to VirtualLinkInterface
    // const NAME = VirtualLinkInterface::NAME;
    // const URL = VirtualLinkInterface::URL;
    // const LINK_ID = VirtualLinkInterface::LINK_ID;
    // const PARENT_LINK_ID = VirtualLinkInterface::PARENT_LINK_ID;
    // const PRIORITY = VirtualLinkInterface::PRIORITY;

    public function getDescription(): string;
    public function getLinkId(): int; 
    public function getMenuId(): int;    
    public function getName(): string;
    public function getParentLinkId(): int;
    public function getPriority(): int;
    public function getUrl(): string;

    /**
     * Return array of sub links
     * 
     * @return LinkDTOInterface[]
     */
    public function getChildrens(): array;
}
