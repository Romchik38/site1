<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\MenuToLinks;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksIdDTOInterface;

class MenuToLinksIdDTO extends DTO implements MenuToLinksIdDTOInterface
{

    public function __construct(
        int $menuId,
        int $linkId,
        int $parentId
    )
    {
        $this->data[MenuToLinksIdDTOInterface::MENU_ID_FIELD] = $menuId;
        $this->data[MenuToLinksIdDTOInterface::LINK_ID_FIELD] = $linkId;
        $this->data[MenuToLinksIdDTOInterface::PARENT_LINK_ID_FIELD] = $parentId;
    }

    public function getIdKeys(): array
    {
        return $this::ID_KEYS;
    }

}
