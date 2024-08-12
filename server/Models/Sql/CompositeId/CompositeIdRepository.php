<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql\CompositeId;

use Romchik38\Server\Api\Models\CompositeId\CompositeIdDTOFactoryInterface;
use Romchik38\Server\Api\Models\CompositeId\CompositeIdDTOInterface;
use Romchik38\Server\Api\Models\CompositeId\CompositeIdModelInterface;
use Romchik38\Server\Api\Models\CompositeId\CompositeIdRepositoryInterface;
use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\ModelFactoryInterface;
use Romchik38\Server\Api\Models\CompositeId\CompositeIdFactoryInterface;
use Romchik38\Server\Models\Errors\{
    CouldNotAddException,
    CouldNotDeleteException,
    CouldNotSaveException,
    NoSuchEntityException,
    QueryExeption,
    DTO\CantCreateDTOException
};

class CompositeIdRepository implements CompositeIdRepositoryInterface
{

    public function __construct(
        protected DatabaseInterface $database,
        protected CompositeIdFactoryInterface $modelFactory,
        protected CompositeIdDTOFactoryInterface $idDTOFactory,
        protected string $table,
    ) {
    }

    public function create(): CompositeIdModelInterface
    {
        return $this->modelFactory->create();
    }

    public function getById(CompositeIdDTOInterface $id): CompositeIdModelInterface
    {

        [$placeHolders, $params] = $this->getParametersFromIdDto($id);

        $query = 'SELECT ' . $this->table . '.* FROM ' . $this->table . ' WHERE '
            . implode(' AND ', $placeHolders) . ';';

        $arr = $this->database->queryParams($query, $params);

        if (count($arr) === 0) {
            throw new NoSuchEntityException('row with complex id ' . implode(', ', $params)
                . ' do not present in the ' . $this->table . ' table');
        }
        $row = $arr[0];

        return $this->createFromRow($row);
    }

    /** 
     * 1 to 1 with the Repository class
     */
    public function list(string $expression, array $params): array
    {
        $entities = [];

        $query = 'SELECT ' . $this->table . '.* FROM ' . $this->table . ' ' . $expression;
        $arr = $this->database->queryParams($query, $params);
        foreach ($arr as $row) {
            $entities[] = $this->createFromRow($row);
        }

        return $entities;
    }

    /** 
     * 1 to 1 with the Repository class
     */
    public function add(CompositeIdModelInterface $model): CompositeIdModelInterface
    {
        $keys = [];
        $values = [];
        $params = [];
        $count = 0;
        foreach ($model->getAllData() as $key => $value) {
            $count++;
            $params[] = '$' . $count;
            $keys[] = $key;
            $values[] = $value;
        }

        $query = 'INSERT INTO ' . $this->table . ' (' . implode(', ', $keys) . ') VALUES ('
            . implode(', ', $params) . ') RETURNING *';
        try {
            $arr = $this->database->queryParams($query, $values);
            $row = $arr[0];
            return $this->createFromRow($row);
        } catch (QueryExeption $e) {
            throw new CouldNotAddException($e->getMessage());
        }
    }

    public function deleteById(CompositeIdDTOInterface $id): void
    {

        [$placeHolders, $params] = $this->getParametersFromIdDto($id);

        $query = 'DELETE FROM ' . $this->table . ' WHERE '
            . implode(' AND ', $placeHolders);
        try {
            $this->database->queryParams($query, $params);
        } catch (QueryExeption $e) {
            throw new CouldNotDeleteException($e->getMessage());
        }
    }

    public function save(CompositeIdModelInterface $model): CompositeIdModelInterface
    {
        // prepare id
        $id = $model->getId();
        $counter = count($id->getAllData());
        [$IdPlaceHolders, $params] = $this->getParametersFromIdDto($id);

        // prepare all fields
        $fields = [];
        foreach ($model->getAllData() as $key => $value) {
            $counter++;
            $fields[] = $key . ' = $' . $counter;
            $params[] = $value;
        }

        $query = 'UPDATE ' . $this->table . ' SET ' . implode(', ', $fields)
            . 'WHERE ' . implode(' AND ', $IdPlaceHolders) . ' RETURNING *';

        try {
            $arr = $this->database->queryParams($query, $params);
            $row = $arr[0];
            return $this->createFromRow($row);
        } catch (QueryExeption $e) {
            throw new CouldNotSaveException($e->getMessage());
        }
    }

    /**
     * Create an entity from provided row
     * 
     * @param array $row ['field' => 'value', ...]
     * @throws CantCreateDTOException
     * @return CompositeIdModelInterface
     */
    protected function createFromRow(array $row): CompositeIdModelInterface
    {
        $entity = $this->create();

        $idDto = $this->idDTOFactory->create($row);
        $entity->setId($idDto);

        foreach ($row as $key => $value) {
            $entity->setData($key, $value);
        }

        return $entity;
    }

    /**
     * Prepare an id data for the query
     * Used in methods: 
     *   - getById
     *   - deleteById
     * 
     * @param CompositeIdDTOInterface $id
     * @return array [ ['fieldname = $1', ...], [$value, ...] ]
     */
    protected function getParametersFromIdDto(CompositeIdDTOInterface $id): array
    {
        $idFields = $id->getIdKeys();
        $counter = 0;
        $placeHolders = [];
        $params = [];

        foreach ($idFields as $field) {
            $counter++;
            $params[] = $id->getData($field);
            $placeHolders[] = $field . ' = $' . $counter;
        }

        return [$placeHolders, $params];
    }
}
