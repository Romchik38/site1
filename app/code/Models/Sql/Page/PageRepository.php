<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\Page;

use Romchik38\Server\Models\Sql\Repository;
use Romchik38\Site1\Api\Models\PageRepositoryInterface;

class PageRepository extends Repository implements PageRepositoryInterface{
    public function getByUrl(string $url): array {
        return $this->list(' WHERE url = $1', [$url]);
    }
}