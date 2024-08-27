<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Sitemap;

use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;

interface SitemapDTOFactoryInterface
{
    public function create(
        string $name,
        string $description,
        ControllerDTOInterface $rootControllerDTO,
        array $menuLinks,
        string $content = '',
    ): SitemapDTOInterface;
}
