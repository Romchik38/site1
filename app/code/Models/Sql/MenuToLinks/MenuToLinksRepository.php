<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\MenuToLinks;

use Romchik38\Server\Models\Sql\CompositeId\CompositeIdRepository;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksRepositoryInterface;

class MenuToLinksRepository extends CompositeIdRepository implements MenuToLinksRepositoryInterface
{
}
