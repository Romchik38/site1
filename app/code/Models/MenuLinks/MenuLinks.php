<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\MenuLinks;

use Romchik38\Server\Models\Model;
use Romchik38\Site1\Api\Models\MenuLinks\MenuLinksInterface;

class MenuLinks extends Model implements MenuLinksInterface
{
    public function getId(): int {
        return $this->data[MenuLinksInterface::LINK_ID_FIELD];
    }

    public function getName(): string {
        return $this->data[MenuLinksInterface::NAME_FIELD];
    }

    public function getUrl(): string {
        return $this->data[MenuLinksInterface::URL_FIELD];
    }

    public function getDescription(): string {
        return $this->data[MenuLinksInterface::DESCRIPTION_FIELD];
    }

    public function setId(int $id): MenuLinksInterface {
        $this->data[MenuLinksInterface::LINK_ID_FIELD] = $id;
        return $this;
    }

    public function setName(string $name): MenuLinksInterface {
        $this->data[MenuLinksInterface::NAME_FIELD] = $name;
        return $this;
    }

    public function setUrl(string $url): MenuLinksInterface {
        $this->data[MenuLinksInterface::URL_FIELD] = $url;
        return $this;
    }

    public function setDescription(string $description): MenuLinksInterface {
        $this->data[MenuLinksInterface::DESCRIPTION_FIELD] = $description;
        return $this;
    }

}
