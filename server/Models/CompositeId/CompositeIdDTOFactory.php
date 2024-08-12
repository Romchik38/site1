<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\CompositeId;

use Romchik38\Server\Api\Models\CompositeId\CompositeIdDTOFactoryInterface;
use Romchik38\Server\Api\Models\CompositeId\CompositeIdDTOInterface;

class CompositeIdDTOFactory implements CompositeIdDTOFactoryInterface
{
    public function create(array $data): CompositeIdDTOInterface {
        return new CompositeIdDTO($data);
    }
}
