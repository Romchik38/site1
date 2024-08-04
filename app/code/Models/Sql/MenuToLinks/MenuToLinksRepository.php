<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\MenuToLinks;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\ModelFactoryInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksRepositoryInterface;

class MenuToLinksRepository implements MenuToLinksRepositoryInterface {

    public function __construct(
        protected DatabaseInterface $database,
        protected ModelFactoryInterface $modelFactory,
        protected string $table,
        protected array $primaryFieldNames
    )
    {
        
    }

    public function create(): MenuToLinksInterface {

    }

    public function getById(MenuToLinksIdDTOInterface $id): MenuToLinksInterface {

    }

    public function list(string $expression, array $params): array {

    }

    public function add(MenuToLinksInterface $model): MenuToLinksInterface {

    }

    public function deleteById(MenuToLinksIdDTOInterface $id): void {

    }

    public function save(MenuToLinksInterface $model): MenuToLinksInterface {

    }
}