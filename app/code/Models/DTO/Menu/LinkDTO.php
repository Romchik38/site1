<?php

namespace Romchik38\Site1\Models\DTO\Menu;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\Menu\LinkDTOInterface;

/**
 * Represents an entity, used in view.
 * It's a menu element 
 */
class LinkDTO extends DTO implements LinkDTOInterface
{

    public function __construct(
        string $description,
        string $name,
        string $url
    ) {
        $this->data[LinkDTOInterface::DESCRIPTION] = $description;
        $this->data[LinkDTOInterface::NAME] = $name;
        $this->data[LinkDTOInterface::URL] = $url;
    }

    public function getDescription(): string
    {
        return $this->data[LinkDTOInterface::DESCRIPTION];
    }

    public function getName(): string
    {
        return $this->data[LinkDTOInterface::NAME];
    }

    public function getUrl(): string
    {
        return $this->data[LinkDTOInterface::URL];
    }
}
