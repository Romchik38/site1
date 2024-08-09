<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Nav;

use Romchik38\Site1\Api\Models\DTO\Menu\LinkDTOInterface;

interface NavDTOFactoryInterface {
    
    /**
     * @param int $menuId [a menu id from menu model]
     * @param LinkDTOInterface[] $links 
     */
    public function create(
        int $menuId,
        array $links 
    ): NavDTOInterface;
}