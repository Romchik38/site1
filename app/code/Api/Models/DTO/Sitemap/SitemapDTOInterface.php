<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Sitemap;

use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Site1\Api\Models\MenuLinks\MenuLinksInterface;

interface SitemapDTOInterface extends DefaultViewDTOInterface
{
    const MENU_LINKS_FIELD = 'menu_links';
    const ROOT_CONTROLLER_DTO_FIELD = 'root_DTO';
    /** 
     * @return MenuLinksInterface[]
     */
    public function getMenuLinks(): array;
    public function getRootControllerDto(): ControllerDTOInterface;
}
