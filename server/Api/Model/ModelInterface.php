<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Model;

interface ModelInterface {
    public function getData(string $key): mixed;
    public function getAllData(): array;
    public function setData(string $key, mixed $value): ModelInterface;
}