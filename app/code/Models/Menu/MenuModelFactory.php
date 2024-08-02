<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Menu;

use Romchik38\Site1\Api\Models\Menu\MenuModelFactoryInterface;
use Romchik38\Server\Api\Models\Menu\MenuModelInterface;

class MenuModelFactory implements MenuModelFactoryInterface {
    public function create(): MenuModelInterface {
        return new MenuModel();
    }
}