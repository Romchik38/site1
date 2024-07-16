<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql;

use Romchik38\Server\Api\Models\EntityFactoryInterface;
use Romchik38\Server\Models\Sql\Entity\EntityModel;

class EntityFactory implements EntityFactoryInterface
{
    public function create(): EntityModel
    {
        return new EntityModel();
    }
}
