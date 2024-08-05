<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\MenuToLinks;

use Romchik38\Server\Models\CompositeId\CompositeIdModel;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksInterface;

class MenuToLinks extends CompositeIdModel implements MenuToLinksInterface
{

    public function getPriority(): int {
        return $this->data[MenuToLinksInterface::PRIORITY_FIELD];
    }

    public function setPriority(string $priority): MenuToLinksInterface {
        $this->data[MenuToLinksInterface::PRIORITY_FIELD] = $priority;
        return $this;
    }
}
