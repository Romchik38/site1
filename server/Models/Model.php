<?php

declare(strict_types=1);

namespace Romchik38\Server\Models;

use Romchik38\Server\Api\Models\ModelInterface;

class Model implements ModelInterface {
    protected array $data = [];

    public function getData(string $key): mixed {
        return $this->data[$key];
    }

    public function getAllData(): array
    {
        return $this->data;
    }

    public function setData(string $key, mixed $value): ModelInterface {
        $this->data[$key] = $value;
        return $this;
    }
}