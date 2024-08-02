<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\MenuLinks;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

interface MenuLinksFactoryInterface extends ModelFactoryInterface
{
    public function create(): MenuLinksInterface;
}
