<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\DefaultView;

use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;

class DefaultViewDTOFactory implements DefaultViewDTOFactoryInterface
{
    public function create(string $name, string $description): DefaultViewDTOInterface
    {
        return new DefaultViewDTO($name, $description);
    }
}
