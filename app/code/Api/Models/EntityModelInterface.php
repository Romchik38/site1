<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models;

interface EntityModelInterface {

    /** FIELDS */
    public function getFieldsData(): array;

    /** ENTITY */
    // public function getEntityId(): int;                  << MOVE THIS TO SPECIFIC ENTITY
    // public function getName(): string;

    public function getEntityData(string $key): mixed;
    public function setEntityData(string $key, $value): EntityModelInterface;
    public function getAllEntityData(): array;
}