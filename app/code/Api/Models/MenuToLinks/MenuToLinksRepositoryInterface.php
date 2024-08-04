<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\MenuToLinks;

use Romchik38\Server\Models\Errors\CouldNotSaveException;
use Romchik38\Server\Models\Errors\CouldNotDeleteException;
use Romchik38\Server\Models\Errors\CouldNotAddException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;

interface MenuToLinksRepositoryInterface
{
    /**
     * Create a new entity
     * @return MenuToLinksInterface
     */
    public function create(): MenuToLinksInterface;

    /**
     * Search in the repository by provided id
     * 
     * @param MenuToLinksIdDTOInterface $id
     * @throws NoSuchEntityException
     * @return MenuToLinksInterface
     */
    public function getById(MenuToLinksIdDTOInterface $id): MenuToLinksInterface;

    /**
     * Search in the repository by provided condition
     * 
     * @param string $expression [condition]
     * @param array $params
     * @return MenuToLinksInterface[]
     */
    public function list(string $expression, array $params): array;

    /**
     * Add new entity
     * 
     * @param MenuToLinksInterface $model [a new entity to save]
     * @throws CouldNotAddException
     * @return MenuToLinksInterface
     */
    public function add(MenuToLinksInterface $model): MenuToLinksInterface;

    /**
     * Delete existing entity by provided id
     * 
     * @throws CouldNotDeleteException  
     * @return void
     */
    public function deleteById(MenuToLinksIdDTOInterface $id): void;

    /**
     * Save existing model
     *
     * @param ModelInterface $model
     * @throws CouldNotSaveException
     * @return ModelInterface
     */
    public function save(MenuToLinksInterface $model): MenuToLinksInterface;
}
