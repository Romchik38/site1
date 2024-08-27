<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Sitemap;

use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Sitemap\SitemapDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Sitemap\SitemapDTOInterface;

class SitemapDTOFactory implements SitemapDTOFactoryInterface
{
    public function create(string $name, string $description, ControllerDTOInterface $rootControllerDTO, array $menuLinks, string $content = ''): SitemapDTOInterface
    {
        return new SitemapDTO(
            $name,
            $description,
            $content,
            $rootControllerDTO,
            $menuLinks
        );
    }
}
