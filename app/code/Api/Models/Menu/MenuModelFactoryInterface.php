<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\Menu;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

interface MenuModelFactoryInterface extends ModelFactoryInterface {
    public function create(): MenuModelInterface;
}