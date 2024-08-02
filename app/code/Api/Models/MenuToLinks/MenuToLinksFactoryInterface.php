<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\MenuToLinks;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

interface MenuToLinksFactoryInterface extends ModelFactoryInterface {
    public function create(): MenuToLinksInterface;
}