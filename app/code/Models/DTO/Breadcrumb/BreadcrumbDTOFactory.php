<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Breadcrumb;

use Romchik38\Site1\Api\Models\DTO\Breadcrumb\BreadcrumbDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Breadcrumb\BreadcrumbDTOInterface;

class BreadcrumbDTOFactory implements BreadcrumbDTOFactoryInterface
{
    public function create(
        string $name,
        string $description,
        string $url,
        BreadcrumbDTOInterface|null $prev
    ): BreadcrumbDTOInterface {
        return new BreadcrumbDTO(
            $name,
            $description,
            $url,
            $prev
        );
    }
}
