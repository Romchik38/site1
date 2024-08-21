<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Breadcrumb;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface BreadcrumbDTOInterface extends DTOInterface
{
    const NAME_FIELD = 'name';
    const DESCRIPTION_FIELD = 'description';
    const URL_FIELD = 'url';
    const PREV_FIELD = 'prev';

    public function getPrev(): BreadcrumbDTOInterface;

    public function getDescription(): string;
    public function getName(): string;
    public function getUrl(): string;
}
