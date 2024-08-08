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
use Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkRepositoryInterface;
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
        protected MenuLinksRepositoryInterface $menuLinksRepository,
        protected VirtualLinkRepositoryInterface $virtualLinkRepository
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

        $linkModels = $this->virtualLinkRepository->getByMenuId($menu->getId());
        

    }
}
