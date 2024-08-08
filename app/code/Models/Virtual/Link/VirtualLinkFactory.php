<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Virtual\Link;

use Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkFactoryInterface;
use Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkInterface;

class VirtualLinkFactory implements VirtualLinkFactoryInterface
{
    public function create(): VirtualLinkInterface
    {
        return new VirtualLink();
    }
}
