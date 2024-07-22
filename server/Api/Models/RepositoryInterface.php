<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models;

use Romchik38\Server\Api\Models\ModelInterface;

interface RepositoryInterface
{
    public function create(): ModelInterface;
    public function getById($id): ModelInterface;
    public function list(string $expression, array $params): array;
    public function add(ModelInterface $model): ModelInterface;
    public function deleteById(int $id): void;
    public function save(ModelInterface $model): ModelInterface;
}
