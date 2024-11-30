<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Mappers;

use Romchik38\Server\Api\Models\DTO\Http\Link\LinkDTOCollectionInterface;
use Romchik38\Server\Models\DTO\Http\Link\LinkDTO as LinkLinkDTO;
use Romchik38\Site1\Api\Models\MenuLinks\MenuLinksInterface;
use Romchik38\Site1\Api\Models\MenuLinks\MenuLinksRepositoryInterface;

final class LinkDTOCollection implements LinkDTOCollectionInterface
{
    public function __construct(
        protected readonly MenuLinksRepositoryInterface $menuLinksRepository
    ) {}

    public function getLinksByPaths(array $paths = []): array
    {
        $menuLinks = $this->menuLinksRepository->list('', []);
        $linkDTOs = [];
        /** @var MenuLinksInterface $model */
        foreach ($menuLinks as $model) {
            $linkDTOs[] =  new LinkLinkDTO(
                $model->getName(),
                $model->getDescription(),
                $model->getUrl()
            );
        }

        return $linkDTOs;
    }
}