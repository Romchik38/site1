<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\MenuToLinks;

interface MenuToLinksRepositoryInterface
{
    public function create(): MenuToLinksInterface;
    public function getById(array $id): MenuToLinksInterface;
    public function list(string $expression, array $params): array;
    public function add(MenuToLinksInterface $model): MenuToLinksInterface;
    public function deleteById(array $id): void;

    /**
     * Save existing model
     *
     * @param ModelInterface $model
     * @throws CouldNotSaveException
     * @return ModelInterface
     */
    public function save(MenuToLinksInterface $model): MenuToLinksInterface;
}
