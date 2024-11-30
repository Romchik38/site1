<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Mappers;

use Romchik38\Server\Api\Models\DTO\Html\Link\LinkDTOCollectionInterface;

final class LinkDTOCollection implements LinkDTOCollectionInterface
{
    public function getLinksByPaths(array $paths): array
    {
        return ['hello'];
    }
}
