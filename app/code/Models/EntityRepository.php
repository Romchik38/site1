<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models;

use Romchik38\Site1\Api\Models\EntityRepositoryInterface;
use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\ModelFactoryInterface;

class EntityRepository implements EntityRepositoryInterface
{
    public function __construct(
        protected DatabaseInterface $database,
        protected ModelFactoryInterface $modelFactory,
        protected string $mainTable,
        protected string $table,
        protected string $primaryFieldName
    )
    {
    }

    
}
