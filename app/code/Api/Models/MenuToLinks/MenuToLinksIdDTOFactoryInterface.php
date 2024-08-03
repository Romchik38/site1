<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\MenuToLinks;

interface MenuToLinksIdDTOFactoryInterface
{
    public function create(
        int $menuId,
        int $linkId,
        int $parrentId = 0
    ): MenuToLinksIdDTOInterface;
}
