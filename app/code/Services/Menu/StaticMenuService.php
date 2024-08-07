<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Menu;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Errors\QueryExeption;
use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;
use Romchik38\Site1\Api\Models\Menu\MenuModelInterface;
use Romchik38\Site1\Api\Services\Menu\StaticMenuServiceInterface;
use Romchik38\Site1\Api\Models\Menu\MenuModelRepositoryInterface;
use Romchik38\Site1\Api\Models\MenuLinks\MenuLinksInterface;
use Romchik38\Site1\Api\Models\MenuLinks\MenuLinksRepositoryInterface;
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
        protected MenuToLinksRepositoryInterface $menuToLinksRepository,
        protected MenuLinksRepositoryInterface $menuLinksRepository
    )
    {
    }

    /**
     * @throws CouldNotCreateMenu 
     */
    public function getMenuById(int $id): MenuDTOInterface
    {
        
        // 1 check id
        try {
            /** @var MenuModelInterface $menu */
            $menu = $this->menuModelRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            throw new CouldNotCreateMenu('menu with id: ' . 'does not present');
        }
        
        // 2 get all links that belong to the menu
        /** 
         * @var LinkDTOInterface[] $links
         * @throws CouldNotCreateMenu
         * */
        $linkDTOs = $this->getLinkDTOs($menu);
        
        // 3 create MenuDTO

    }

    /**
     * Return array of link entities
     * 
     * @return LinkDTOInterface[]
     */
    protected function getLinkDTOs(MenuModelInterface $menu): array {
        // 1. menuTolinks
        $expression = MenuDTOInterface::ID_FIELD . ' = $1';
        $params = [$menu->getId()];
        try {
            /** @var MenuToLinksInterface[] $menuTolinks */
            $menuTolinks = $this->menuToLinksRepository->list($expression, $params);
        } catch (QueryExeption $e) {
            throw new CouldNotCreateMenu($e->getMessage());
        }

        // 2. menuLinks
        $conditions = [];
        $params = [];
        $counter = 0;
        foreach($menuTolinks as $menuToLink) {
            $counter++;
            $conditions[] = MenuLinksInterface::LINK_ID_FIELD . '= $' . $counter; 
            $params[] = $menuToLink->getLinkId();
        }
        
        $expression = implode(' OR ', $conditions);
        try {
            /** @var MenuLinksInterface[] $menuLinks */
            $menuLinks = $this->menuLinksRepository->list($expression, $params);
        } catch (QueryExeption $e) {
            throw new CouldNotCreateMenu($e->getMessage());
        }

        // 3 so we have all entities: $menu, $menuLinks, $menuTolinks
        
    }
}
