<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Sitemap\DefaultAction;

use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

class SitemapDTO extends DefaultViewDTO implements DefaultViewDTOInterface
{

    public function __construct(
        protected readonly string $name,
        protected readonly string $description,
        public readonly string $output
    ) {}

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
