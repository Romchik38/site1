<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql;

use Romchik38\Site1\Api\Models\EntityFactoryInterface;
use Romchik38\Site1\Models\Sql\EntityModel;

class EntityFactory implements EntityFactoryInterface
{
    public function create(): EntityModel
    {
        return new EntityModel();
    }
}
