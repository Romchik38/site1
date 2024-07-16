<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql\Entity;

use Romchik38\Server\Api\Models\Entity\EntityModelInterface;

class EntityModel implements EntityModelInterface {

    /**
     * stores entity primary fields
     */
    private array $entityData = [];

    /**
     * stores field/values of the entity
     * 
     * $fieldsData string[]
     */
    private array $fieldsData = [];

    /**
     * returns an array of all fileds and values
     * 
     * @return array
     */
    public function getFieldsData(): array {
        return $this->fieldsData;
    }

    /**
     * get a value by provided field name
     * 
     */
    public function __get(string $field) {
        return $this->fieldsData[$field];
    }

    /**
     * set field/value
     * 
     *  @return void
     */
    public function __set(string $field, $val): void {
        $this->fieldsData[$field] = $val;
    }

    public function getAllEntityData(): array {
        return $this->entityData;
    }

    public function getEntityData(string $key): int|string|float {
        return $this->entityData[$key];
    }

    public function setEntityData(string $key, $value): EntityModelInterface {
        $this->entityData[$key] = $value;
        return $this;
    }

}