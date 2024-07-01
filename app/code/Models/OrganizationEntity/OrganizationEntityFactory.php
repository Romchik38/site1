<?php 

declare(strict_types=1);

namespace Romchik38\Site1\Models\OrganizationEntity;

use Romchik38\Site1\Api\Models\OrganizationEntity\OrganizationEntityFactoryInterface;
use Romchik38\Site1\Models\OrganizationEntity\OrganizationEntityModel;

class OrganizationEntityFactory implements OrganizationEntityFactoryInterface {
    public function create(): OrganizationEntityModel
    {
        return new OrganizationEntityModel();
    }
}