<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Services\Menu;

use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;

interface StaticMenuServiceInterface {
    public function getMenuById(int $id): MenuDTOInterface;
}