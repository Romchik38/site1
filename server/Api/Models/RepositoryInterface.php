<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models;

use Romchik38\Server\Api\Models\ModelInterface;
use Romchik38\Server\Models\Errors\CouldNotSaveException;

interface RepositoryInterface
{
    public function create(array $row = null): ModelInterface;
    public function getById($id): ModelInterface;
    public function list(string $expression, array $params): array;
    public function add(ModelInterface $model): ModelInterface;
    public function deleteById(int $id): void;

    /**
     * Save existing model
     *
     * @param ModelInterface $model
     * @throws CouldNotSaveException
     * @return ModelInterface
     */
    public function save(ModelInterface $model): ModelInterface;
}
