<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Nav;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\Nav\NavDTOInterface;

class NavDTO extends DTO implements NavDTOInterface
{
    public function __construct(
        int $menuId,
        readonly protected array $links
    ) {
        $this->data[NavDTOInterface::NAV_MENU_ID_FIELD] = $menuId;
    }

    public function getLinks()
    {
        return $this->links;
    }
}
