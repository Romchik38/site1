<?php 

declare(strict_types=1);

namespace Romchik38\Site1\Models\Entity;

use Romchik38\Site1\Api\Models\EntityFactoryInterface;
use Romchik38\Site1\Models\EntityModel;

class EntityFactory implements EntityFactoryInterface {
    public function create(): EntityModel
    {
        return new EntityModel();
    }
}