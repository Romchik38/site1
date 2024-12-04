<?php

namespace Romchik38\Site1\Api\Models\DTO\Main;

use Romchik38\Site1\Application\PageView\Views\Page;

interface MainDTOFactoryInterface
{
    public function create(
        Page $page,
        string $name,
        string $description
    ): MainDTOInterface;
}
