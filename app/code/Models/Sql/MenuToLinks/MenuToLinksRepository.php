<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\MenuToLinks;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\ModelFactoryInterface;
use Romchik38\Server\Models\Errors\CouldNotAddException;
use Romchik38\Server\Models\Errors\CouldNotDeleteException;
use Romchik38\Server\Models\Errors\CouldNotSaveException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Errors\DTO\CantCreateDTOException;
use Romchik38\Server\Models\Errors\QueryExeption;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksIdDTOFactoryInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksIdDTOInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksRepositoryInterface;

class MenuToLinksRepository implements MenuToLinksRepositoryInterface
{

    public function __construct(
        protected DatabaseInterface $database,
        protected ModelFactoryInterface $menuToLinkFactory,
        protected MenuToLinksIdDTOFactoryInterface $menuToLinksIdFactory,
        protected string $table,
        // protected array $primaryFieldNames     ? delete
    ) {
    }

    public function create(): MenuToLinksInterface
    {
        return $this->menuToLinkFactory->create();
    }

    public function getById(MenuToLinksIdDTOInterface $id): MenuToLinksInterface
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
    public function add(MenuToLinksInterface $model): MenuToLinksInterface
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

    public function deleteById(MenuToLinksIdDTOInterface $id): void
    {

        [$placeHolders, $params] = $this->getParametersFromIdDto($id);

        $query = 'DELETE FROM ' . $this->table . ' WHERE '
            . implode(' AND ', $placeHolders);
        try {
            $this->database->queryParams($query, $params);
        } catch (QueryExeption $e) {
            throw new CouldNotDeleteException ($e->getMessage());
        }
    }

    public function save(MenuToLinksInterface $model): MenuToLinksInterface
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
     * @return MenuToLinksInterface
     */
    protected function createFromRow(array $row): MenuToLinksInterface
    {
        $entity = $this->create();

        // 1 create an id dto
        $idDto = $this->menuToLinksIdFactory->create($row);
        $entity->setId($idDto);

        // 2 fill fields
        foreach ($row as $key => $value) {
            $entity->setData($key, $value);
        }

        // 3 job is done
        return $entity;
    }

    /**
     * Prepare id data for the query
     * Used in methods: 
     *   - getById
     *   - deleteById
     * 
     * @param MenuToLinksIdDTOInterface $id
     * @return array [ ['fieldname = $1', ...], [$value, ...] ]
     */
    protected function getParametersFromIdDto(MenuToLinksIdDTOInterface $id): array
    {
        $idFields = MenuToLinksIdDTOInterface::ID_KEYS;
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
