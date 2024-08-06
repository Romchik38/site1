<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Menu;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

/**
 * Represents an entity, used in a view.
 * It's a menu element 
 */
interface LinkDTOInterface extends DTOInterface
{
    const DESCRIPTION = 'description';
    const NAME = 'name';
    const URL = 'url';
    const LINK_ID = 'link_id';
    const PARENT_LINK_ID = 'parent_link_id';
    const PRIORITY = 'priority';

    public function getDescription(): string;
    public function getLinkId(): int;    
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
