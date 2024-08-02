<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\MenuLinks;

use Romchik38\Site1\Api\Models\MenuLinks\MenuLinksFactoryInterface;
use Romchik38\Site1\Api\Models\MenuLinks\MenuLinksInterface;

class MenuLinksFactory implements MenuLinksFactoryInterface {
    public function create(): MenuLinksInterface
    {
        return new MenuLinks();
    }
}