<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\Virtual\Link;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

interface VirtualLinkFactoryInterface extends ModelFactoryInterface
{
    public function create(): VirtualLinkInterface;
}
