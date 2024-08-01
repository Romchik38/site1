<?php

namespace Romchik38\Site1\Models\DTO\Menu;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;

/**
 * Represents an entity, used in view.
 * It's a menu element 
 */
class MenuDTO extends DTO implements MenuDTOInterface
{

    public function __construct(
        string $description,
        string $name,
        string $url
    ) {
        $this->data[MenuDTOInterface::DESCRIPTION] = $description;
        $this->data[MenuDTOInterface::NAME] = $name;
        $this->data[MenuDTOInterface::URL] = $url;
    }

    public function getDescription(): string
    {
        return $this->data[MenuDTOInterface::DESCRIPTION];
    }

    public function getName(): string
    {
        return $this->data[MenuDTOInterface::NAME];
    }

    public function getUrl(): string
    {
        return $this->data[MenuDTOInterface::URL];
    }
}
