<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Sitemap;

use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Sitemap\SitemapDTOInterface;
use Romchik38\Site1\Models\DTO\DefaultView\DefaultViewDTO;

class SitemapDTO extends DefaultViewDTO implements SitemapDTOInterface
{

    public function __construct(
        string $name,
        string $description,
        string $content,
        ControllerDTOInterface $rootControllerDTO,
        array $menuLinks
    ) {
        $this->data[DefaultViewDTOInterface::DEFAULT_CONTENT_FIELD] = $content;
        $this->data[DefaultViewDTOInterface::DEFAULT_DESCRIPTION_FIELD] = $description;
        $this->data[DefaultViewDTOInterface::DEFAULT_NAME_FIELD] = $name;
        $this->data[SitemapDTOInterface::ROOT_CONTROLLER_DTO_FIELD] = $rootControllerDTO;
        $this->data[SitemapDTOInterface::MENU_LINKS_FIELD] = $menuLinks;
    }


    public function getMenuLinks(): array
    {
        return $this->getData(SitemapDTOInterface::MENU_LINKS_FIELD);
    }

    public function getRootControllerDto(): ControllerDTOInterface
    {
        return $this->getData(SitemapDTOInterface::ROOT_CONTROLLER_DTO_FIELD);
    }
}
