<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\MenuToLinks;

use Romchik38\Server\Models\Model;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksIdDTOInterface;
use Romchik38\Site1\Api\Models\MenuToLinks\MenuToLinksInterface;

class MenuToLinks extends Model implements MenuToLinksInterface
{
    public function getId(): MenuToLinksIdDTOInterface {
        return $this->data[MenuToLinksInterface::FULL_ID_NAME];
    }

    public function getPriority(): int {
        return $this->data[MenuToLinksInterface::PRIORITY_FIELD];
    }

    public function setId(MenuToLinksIdDTOInterface $id): MenuToLinksInterface {
        $this->data[MenuToLinksInterface::FULL_ID_NAME] = $id;
        return $this;
    }

    public function setPriority(string $priority): MenuToLinksInterface {
        $this->data[MenuToLinksInterface::PRIORITY_FIELD] = $priority;
        return $this;
    }
}
