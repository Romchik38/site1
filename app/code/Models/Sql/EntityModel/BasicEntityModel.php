<?php

declare(strict_types=1);

namespace Romchick38\Site1\Models\Sql\EntityModel;

use Romchik38\Server\Models\EntityModel;
use Romchik38\Server\Api\Models\Entity\EntityModelInterface;

class BasicEntityModel extends EntityModel{
    const ID_FIELD = 'entity_id';
    const NAME_FIELD = 'name';

    /**
     * returns entity id
     */
    public function getEntityId(): int {
        return (int)$this->entityData[$this::ID_FIELD];
    }

    /** 
     * returns entity name
     */
    public function getName(): string {
        return $this->entityData[$this::NAME_FIELD];
    }

    public function setName(string $name): EntityModelInterface {
        $this->entityData[$this::NAME_FIELD] = $name;
        return $this;
    }
}