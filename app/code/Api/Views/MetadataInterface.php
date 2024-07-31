<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Views;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface MetadataInterface {
    public function getHeaderData(): DTOInterface;
    // public function getNavData(): DTOInterface;
    // public function getFooterData(): DTOInterface;
}