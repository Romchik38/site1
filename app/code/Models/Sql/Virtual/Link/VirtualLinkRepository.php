<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\Virtual\Link;

use Romchik38\Server\Models\Sql\Virtual\VirtualRepository;
use Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkRepositoryInterface;

class VirtualLinkRepository extends VirtualRepository implements VirtualLinkRepositoryInterface
{
    public function getByMenuId(int $id): array
    {
        $expression = ' WHERE menu_to_links.menu_id = $1 AND menu_to_links.link_id = menu_links.link_id';
        return $this->list($expression, [$id]);
    }
}
