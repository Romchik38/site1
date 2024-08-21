<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Breadcrumb;

interface BreadcrumbDTOFactoryInterface
{
    public function create(
        string $name,
        string $description,
        string $url,
        BreadcrumbDTOInterface|null $prev
    ): BreadcrumbDTOInterface;
}
