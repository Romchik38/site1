<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\EntityModel;

use Romchik38\Server\Api\Models\Entity\EntityFactoryInterface;
use Romchik38\Site1\Models\Sql\EntityModel\BasicEntityModel;

class BasicEntityFactory implements EntityFactoryInterface {
    public function create(): BasicEntityModel
    {
        return new BasicEntityModel();
    }
}