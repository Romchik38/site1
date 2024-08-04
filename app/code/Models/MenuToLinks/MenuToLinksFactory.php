<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\MenuToLinks;

use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksFactoryInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksInterface;

class MenuToLinksFactory implements MenuToLinksFactoryInterface {
    public function create(): MenuToLinksInterface
    {
        return new MenuToLinks();
    }
}