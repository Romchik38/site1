<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO;

use Romchik38\Server\Api\Models\DTOInterface;

interface RegisterDTOInterface extends DTOInterface {
    public function getFieldsNames(): array;
    public function setFields(array $fields): RegisterDTOInterface;
}