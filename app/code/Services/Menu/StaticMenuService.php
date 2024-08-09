<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Menu;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\DTO\Menu\LinkDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;
use Romchik38\Site1\Api\Models\Menu\MenuModelInterface;
use Romchik38\Site1\Api\Services\Menu\StaticMenuServiceInterface;
use Romchik38\Site1\Api\Models\Menu\MenuModelRepositoryInterface;
use Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkRepositoryInterface;
use Romchik38\Site1\Services\Errors\Menu\CouldNotCreateMenu;
use Romchik38\Site1\Api\Models\Virtual\Link\VirtualLinkInterface;
use Romchik38\Site1\Api\Models\DTO\Menu\LinkDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOFactoryInterface;

class StaticMenuService extends StaticMenuServiceInterface
{
    /** menu hash
     * @var array $menus [id => MenuDTOInterface]
     */
    protected array $menus = [];

    public function __construct(
        protected MenuModelRepositoryInterface $menuModelRepository,
        protected VirtualLinkRepositoryInterface $virtualLinkRepository,
        protected LinkDTOFactoryInterface $linkDTOFactory,
        protected MenuDTOFactoryInterface $menuDTOFactory
    ) {}

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
        $menuDTO = $this->menuDTOFactory->create(
            $menu->getId(),
            $menu->getName(),
            $linkDTOs
        );
        
        return $menuDTO;
    }

    /**
     * Return array of link entities
     * 
     * @throws CouldNotCreateMenu
     * @return LinkDTOInterface[]
     */
    protected function getLinkDTOs(MenuModelInterface $menu): array
    {
        $linkModels = $this->virtualLinkRepository->getByMenuId($menu->getId());

        /** @var array $dep [linkId => [childLinkId, ...], ...] */
        $dep = $this->prepareDep($linkModels);
        $hash = [];
        // move from $dep to $hash
        $isCercular = false;
        while ($isCercular === false) {
            $isCercular = true;
            [$updatedHaveDep, $updatedHash] = createLink($dep, $hash, $linkModels);
            if (count($updatedHash) > count($hash)) {
                $isCercular = false;
                $hash = $updatedHash;
                $dep = $updatedHaveDep;
            }
        }
        // 3 check on cercular
        if (count($linkModels) !== count($hash)) {
            throw new CouldNotCreateMenu('There are cercular dependencies in the menu: ' . $menu->getId());
        }

        // 4 create a list of LinkDTOInterface
        $linkList = [];
        /** @var LinkDTOInterface $elem*/
        foreach ($hash as $elem) {
            if ($elem->getParentLinkId() === 0) {
                $linkList[] = $elem;
            }
        }
        return $linkList;
    }

    /**
     * Uses initial data ( $data ) to create a temporary hash table "from" ( $dep )
     * In createLink() this data ( $dep ) will migrate to table "to" ( $hash )
     */
    protected function prepareDep(array $data): array
    {
        $dep = [];
        $counter = 0;
        while ($counter < count($data)) {
            /** @var VirtualLinkInterface $elem */
            $elem = $data[$counter];
            /** @var VirtualLinkInterface $innerElem */
            foreach ($data as $innerElem) {
                if ($elem->getLinkId() === $innerElem->getLinkId()) {
                    continue;
                }
                if ($elem->getLinkId() === $innerElem->getParentLinkId()) {
                    $innerDep = $dep[$elem->getLinkId()] ?? [];
                    array_push($innerDep, $innerElem->getLinkId());
                    $dep[$elem->getLinkId()] = $innerDep;
                }
            }
            if (key_exists($elem->getLinkId(), $dep) === false) {
                $dep[$elem->getLinkId()] = [];
            }
            $counter++;
        }
        return $dep;
    }

    protected function createLink($haveDep, $hash, $inititalData)
    {
        $newHaveDep = [];
        foreach ($haveDep as $linkId => $depArr) {
            // check in nodep
            $isReady = true;
            $depInstancies = [];
            foreach ($depArr as $depLinkId) {
                if (key_exists($depLinkId, $hash) === false) {
                    $isReady = false;
                } else {
                    $depInstancies[] = $hash[$depLinkId];
                }
            }
            if ($isReady === false) {
                // check on cercular
                $newHaveDep[$linkId] = $depArr;
                continue;
            }
            // create
            /** @var VirtualLinkInterface $innerElem */
            foreach ($inititalData as $innerElem) {
                if ($innerElem->getLinkId() === $linkId) {
                    $linkDTO = $this->linkDTOFactory->create(
                        $innerElem->getDescription(),
                        $innerElem->getName(),
                        $innerElem->getUrl(),
                        $innerElem->getMenuId(),
                        $innerElem->getLinkId(),
                        $innerElem->getParentLinkId(),
                        $innerElem->getPriority(),
                        $depInstancies
                    );
                    $hash[$linkDTO->getLinkId()] = $linkDTO;
                }
            }
        }

        return [$newHaveDep, $hash];
    }
}
