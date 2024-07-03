<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models;

use Romchik38\Site1\Api\Models\EntityRepositoryInterface;
use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site1\Api\Models\EntityFactoryInterface;

class EntityRepository implements EntityRepositoryInterface
{
    public function __construct(
        protected DatabaseInterface $database,
        protected EntityFactoryInterface $entityFactory,
        protected string $entityTable,
        protected string $fieldsTables,
        protected string $primaryEntityFieldName
    ) {
    }

    public function add(EntityModelInterface $model): EntityModelInterface
    {
    }

    public function create(): EntityModelInterface
    {
    }

    public function deleteById(int $id): void
    {
    }

    public function deleteFields(array $fields, EntityModelInterface $entity): EntityModelInterface
    {
    }

    public function getById(int $id): EntityModelInterface
    {
    }
    public function list(string $expression, array $params): array
    {
    }
    public function save(EntityModelInterface $model): EntityModelInterface
    {
    }
}
