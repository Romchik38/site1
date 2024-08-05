<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\MenuToLinks;

use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksIdDTOFactoryInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksIdDTOInterface;
use Romchik38\Server\Models\Errors\DTO\CantCreateDTOException;

class MenuToLinksIdDTOFactory implements MenuToLinksIdDTOFactoryInterface
{

    public function create(array $data): MenuToLinksIdDTOInterface
    {
        $menuId = $data[MenuToLinksIdDTOInterface::MENU_ID_FIELD] ??
            throw new CantCreateDTOException('menu id key does not exist');
        $linkId = $data[MenuToLinksIdDTOInterface::LINK_ID_FIELD] ??
            throw new CantCreateDTOException('link id key does not exist');;
        $parentId = $data[MenuToLinksIdDTOInterface::PARENT_LINK_ID_FIELD] ?? 0;

        return new MenuToLinksIdDTO(
            (int)$menuId,
            (int)$linkId,
            (int)$parentId
        );
    }
}
