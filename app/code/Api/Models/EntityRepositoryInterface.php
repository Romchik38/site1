<?php 

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models;

use Romchik38\Site1\Api\Models\EntityModelInterface;

interface EntityRepositoryInterface {
    public function add(EntityModelInterface $model): EntityModelInterface;
    public function create(): EntityModelInterface;
    public function deleteById(int $id): void;
    public function deleteFields(array $fields, EntityModelInterface $entity): EntityModelInterface;
    public function getById(int $id): EntityModelInterface;
    public function listByEntities(string $expression, array $params): array;
    public function  listByFields(string $expression, array $params): array;
    public function save(EntityModelInterface $model): EntityModelInterface;
}