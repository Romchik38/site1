<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Services\Menu;

use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;
use Romchik38\Site1\Services\Errors\Menu\CouldNotCreateMenu;

interface StaticMenuServiceInterface
{
    /**
     * @throws CouldNotCreateMenu 
     */
    public function getMenuById(int $id): MenuDTOInterface;
}
