<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql;

use Romchik38\Server\Api\Models\RepositoryInterface;
use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\ModelInterface;
use Romchik38\Server\Api\Models\ModelFactoryInterface;
use Romchik38\Server\Models\Errors\{
    NoSuchEntityException, CouldNotDeleteException, CouldNotSaveException, 
    QueryExeption, CouldNotAddException};

class Repository implements RepositoryInterface
{

    public function __construct(
        protected DatabaseInterface $database,
        protected ModelFactoryInterface $modelFactory,
        protected string $table,
        protected string $primaryFieldName
    ) {
    }

    /**
     * Create an entity from provided row
     *   or
     * an empty entity if the row wasn't provided
     *
     * @param array $row [explicite description]
     *
     * @return ModelInterface
     */
    public function create(array $row = null): ModelInterface
    {
        $entity = $this->modelFactory->create();
        if ($row !== null) {
            foreach ($row as $key => $value) {
                $entity->setData($key, $value);
            }
        }

        return $entity;
    }

    /**
     * Find an entity by provided id
     *
     * @param int $id [Entity Primary key]
     * @throws NoSuchEntityException
     * @return ModelInterface
     */
    public function getById($id): ModelInterface
    {
        $query = 'SELECT * FROM '
            . $this->table
            . ' WHERE ' . $this->primaryFieldName . ' = $1';
        $params = [$id];
        $arr = $this->database->queryParams($query, $params);
        if (count($arr) === 0) {
            throw new NoSuchEntityException('row with id ' . $id
                . ' do not present in the ' . $this->table . ' table');
        }
        $row = $arr[0];

        return $this->create($row);
    }

    /**
     * Return a list of Models
     *
     * @param string $expression [like WHERE first_name = 'bob']
     *
     * @return ModelInterface[]
     */
    public function list(string $expression = '', array $params = []): array
    {
        $entities = [];

        $query = 'SELECT ' . $this->table . '.* FROM ' . $this->table . ' ' . $expression;
        $arr = $this->database->queryParams($query, $params);
        foreach ($arr as $row) {
            $entities[] = $this->create($row);
        }

        return $entities;
    }

    /**
     * insert row to database
     *
     * @param ModelInterface $user 
     *
     * @return ModelInterface 
     */
    public function add(ModelInterface $user): ModelInterface
    {
        $keys = [];
        $values = [];
        $params = [];
        $count = 0;
        foreach ($user->getAllData() as $key => $value) {
            $count++;
            $params[] = '$' . $count;
            $keys[] = $key;
            $values[] = "$value";
        }

        $query = 'INSERT INTO ' . $this->table . ' (' . implode(', ', $keys) . ') VALUES ('
            . implode(', ', $params) . ') RETURNING *';
        try {
            $arr = $this->database->queryParams($query, $values);
            $row = $arr[0];
            return $this->create($row);
        } catch (QueryExeption $e) {
            throw new CouldNotAddException($e->getMessage());
        }
    }

    /**
     * Delete a row from the table
     *
     * @param int $id [PRIMARY KEY of the table]
     * @throws CouldNotDeleteException
     * @return void
     */
    public function deleteById(int $id): void
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE '
            . $this->primaryFieldName . ' = $1';
        try {
            $this->database->queryParams($query, [$id]);
        } catch (QueryExeption $e) {
            throw new CouldNotDeleteException($e->getMessage());
        }
    }

    /**
     * Update a row in the table
     *
     * @param ModelInterface $model 
     * @throws CouldNotSaveException
     * @return ModelInterface 
     */
    public function save(ModelInterface $model): ModelInterface
    {
        $fields = [];
        foreach ($model->getAllData() as $key => $value) {
            $fields[] = $key . ' = \'' . $value . '\'';
        }
        $query = 'UPDATE ' . $this->table . ' SET ' . implode(', ', $fields)
            . 'WHERE ' . $this->primaryFieldName . ' = $1 RETURNING *';
        $params = [$model->getData($this->primaryFieldName)];
        try {
            $arr = $this->database->queryParams($query, $params);
            $row = $arr[0];
            return $this->create($row);
        } catch (QueryExeption $e) {
            throw new CouldNotSaveException($e->getMessage());
        }
    }
}
