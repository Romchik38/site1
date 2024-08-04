<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\MenuToLinks;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\ModelFactoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Errors\DTO\CantCreateDTOException;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksIdDTOFactoryInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksIdDTOInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksRepositoryInterface;
use Romchik38\Site1\Models\MenuToLinks\MenuToLinksIdDTOFactory;

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

        $idFields = MenuToLinksIdDTOInterface::ID_KEYS;
        $counter = 0;
        $placeHolders = [];
        $params = [];

        foreach ($idFields as $field) {
            $counter++;
            $params[] = $id->getData($field);
            $placeHolders[] = $field . ' = $' . $counter;
        }

        $query = 'SELECT ' . $this->table . '.* FROM ' . $this->table . ' WHERE '
            . implode(' AND ', $placeHolders) . '; = $1';

        $arr = $this->database->queryParams($query, $params);

        if (count($arr) === 0) {
            throw new NoSuchEntityException('row with complex id ' . implode(', ', $params)
                . ' do not present in the ' . $this->table . ' table');
        }
        $row = $arr[0];

        return $this->createFromRow($row);
    }







    public function list(string $expression, array $params): array
    {
    }

    public function add(MenuToLinksInterface $model): MenuToLinksInterface
    {
    }

    public function deleteById(MenuToLinksIdDTOInterface $id): void
    {
    }

    public function save(MenuToLinksInterface $model): MenuToLinksInterface
    {
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
}
