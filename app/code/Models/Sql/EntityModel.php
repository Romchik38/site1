<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql;

use Romchik38\Site1\Api\Models\EntityModelInterface;

class EntityModel implements EntityModelInterface {

    /**
     * stores entity id and entity name
     */
    private array $entityData = [];

    /**
     * stores field/values of the entity
     * 
     * $data string|int|float[]
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
     * returns entity id
     */
    // public function getEntityId(): int {
    //     return (int)$this->entityData[EntityModelInterface::ID_FIELD];
    // }

    /** 
     * returns entity name
     */
    // public function getName(): string {
    //     return $this->entityData[EntityModelInterface::NAME_FIELD];
    // }

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

    public function getEntityData(string $key): int|string|float {
        return $this->entityData[$key];
    }

    public function setEntityData(string $key, $value): EntityModelInterface {
        $this->entityData[$key] = $value;
        return $this;
    }
}