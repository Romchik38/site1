<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models;

use Romchik38\Site1\Api\Models\EntityRepositoryInterface;
use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site1\Api\Models\EntityFactoryInterface;
use Romchik38\Site1\Api\Models\EntityModelInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;

class EntityRepository implements EntityRepositoryInterface
{
    public function __construct(
        protected DatabaseInterface $database,
        protected EntityFactoryInterface $entityFactory,
        protected string $entityTable,
        protected string $fieldsTable,
        protected string $primaryEntityFieldName
    ) {
    }

    public function add(EntityModelInterface $model): EntityModelInterface
    {
    }

    /**
     * create an empty entity
     *
     * @return EntityModelInterface
     */
    public function create(): EntityModelInterface
    {
        return $this->entityFactory->create();
    }

    public function deleteById(int $id): void
    {
    }

    public function deleteFields(array $fields, EntityModelInterface $entity): EntityModelInterface
    {
    }

    /**
     * find an entity by provided id
     *
     * @param integer $id
     * @throws NoSuchEntityException
     * @return EntityModelInterface
     */
    public function getById(int $id): EntityModelInterface
    {
        // 1. find an entity
        $query = 'SELECT * FROM '
        . $this->entityTable
        . ' WHERE ' . $this->primaryEntityFieldName . ' = $1';
        $params = [$id];
        $arr = $this->database->queryParams($query, $params);
        if (count($arr) === 0) {
            throw new NoSuchEntityException('row with id ' . $id
                . ' do not present in the ' . $this->primaryEntityFieldName . ' table');
        }
        $entityRow = $arr[0];
        // 2. select all fields
        $queryFields = 'SELECT * FROM '
        . $this->fieldsTable
        . ' WHERE ' . $this->primaryEntityFieldName . ' = $1';
        $paramsFields = [$id];
        $fieldsRow = $this->database->queryParams($queryFields, $paramsFields);

    return $this->createFromRow($entityRow, $fieldsRow);

    }

    /**
     * create a list of intities by provided expression 
     *
     * @param string $expression [use entity id or name]
     * @param array $params
     * @return array
     */
    public function listByEntities(string $expression, array $params): array
    {
        $entities = [];

        // 1 select entities
        $query = 'SELECT ' . $this->entityTable . '.* FROM ' . $this->entityTable . ' ' . $expression;
        $arr = $this->database->queryParams($query, $params);

        // 2. select fields
        foreach ($arr as $entityRow) {
            $queryFields = 'SELECT ' . $this->fieldsTable . '.* FROM ' 
                . $this->fieldsTable . ' WHERE ' . $this->primaryEntityFieldName . ' = ' 
                . $entityRow[$this->primaryEntityFieldName];
            $fieldsRow = $this->database->queryParams($queryFields, []);
            $entities[] = $this->createFromRow($entityRow, $fieldsRow);
        }

        return $entities;
    }

    public function  listByFields(string $expression, array $params): array {

    }

    public function save(EntityModelInterface $model): EntityModelInterface
    {
    }

    /**
     * create an entity from row
     *
     * @param array $entityRow
     * @param array $fieldsRow
     * @return EntityModelInterface
     */
    protected function createFromRow(array $entityRow, array $fieldsRow): EntityModelInterface
    {
        $entity = $this->entityFactory->create();
        foreach ($entityRow as $key => $value) {
            $entity->setEntityData($key, $value);
        }

        foreach ($fieldsRow as $key => $value) {
            $entity->$key = $value;
        }

        return $entity;
    }
}
