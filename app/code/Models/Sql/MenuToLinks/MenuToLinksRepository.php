<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\MenuToLinks;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\ModelFactoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksIdDTOInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksRepositoryInterface;

class MenuToLinksRepository implements MenuToLinksRepositoryInterface
{

    public function __construct(
        protected DatabaseInterface $database,
        protected ModelFactoryInterface $menuToLinkFactory,
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

        $query = 'SELECT * FROM ' . $this->table . ' WHERE '
            . implode(' AND ', $placeHolders) . '; = $1';

        $arr = $this->database->queryParams($query, $params);

        if (count($arr) === 0) {
            throw new NoSuchEntityException('row with complex id ' . implode(', ', $params)
                . ' do not present in the ' . $this->table . ' table');
        }
        $row = $arr[0];

        return $this->create($row);
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
}
