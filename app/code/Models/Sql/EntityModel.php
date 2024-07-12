<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql;

use Romchik38\Site1\Api\Models\EntityModelInterface;

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
     * @return string|int|float
     */
    public function __get(string $field): string|int|float {
        return $this->data[$field];
    }

    /**
     * set field/value
     * 
     *  @return void
     */
    public function __set(string $field, $val): void {
        $this->data[$field] = $val;
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