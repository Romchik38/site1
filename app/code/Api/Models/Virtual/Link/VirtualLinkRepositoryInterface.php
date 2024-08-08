<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\Virtual\Link;

use Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkInterface;

interface VirtualLinkRepositoryInterface
{
    /** 
     * @return VirtualLinkInterface[];
     */
    public function getByMenuId(int $id): array;
}
