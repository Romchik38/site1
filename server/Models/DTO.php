<?php

declare(strict_types=1);

namespace Romchik38\Server\Models;

use Romchik38\Server\Api\Models\DTOInterface;

class DTO implements DTOInterface {
    protected array $data = [];

    public function getData(string $key): mixed {
        if (array_key_exists($key, $this->data) === true) {
            return $this->data[$key];
        }
        return null;
    }

    public function getAllData(): array
    {
        return $this->data;
    }

}