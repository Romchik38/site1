<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\OrganizationEntity;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

interface OrganizationEntityFactoryInterface extends ModelFactoryInterface{
    public function create(): OrganizationEntityModelInterface;
}