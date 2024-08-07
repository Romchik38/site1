<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Menu;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;
use Romchik38\Site1\Api\Services\Menu\StaticMenuServiceInterface;
use Romchik38\Site1\Api\Models\Menu\MenuModelRepositoryInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksRepositoryInterface;
use Romchik38\Site1\Services\Errors\Menu\CouldNotCreateMenu;

class StaticMenuService extends StaticMenuServiceInterface
{
    /** menu hash
     * @var array $menus [id => MenuDTOInterface]
     */
    protected array $menus = [];

    public function __construct(
        protected MenuModelRepositoryInterface $menuModelRepository,
        protected MenuToLinksRepositoryInterface $menuToLinksRepository
    )
    {
    }

    public function getMenuById(int $id): MenuDTOInterface
    {
        // 1 check id
        try {
            $menu = $this->menuModelRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            throw new CouldNotCreateMenu('menu with id: ' . 'does not present');
        }
        // 2 get all links that belong to the menu
        $expression = MenuDTOInterface::ID_FIELD . ' = $1';
        $params = [$id];
        /** @var MenuToLinksInterface[] $menuTolinks */
        $menuTolinks = $this->menuToLinksRepository->list($expression, $params);

    }
}
