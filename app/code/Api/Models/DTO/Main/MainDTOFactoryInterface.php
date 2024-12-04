<?php

namespace Romchik38\Site1\Api\Models\DTO\Main;

use Romchik38\Site1\Domain\Page\PageModelInterface;

interface MainDTOFactoryInterface
{
    public function create(
        PageModelInterface $page,
        string $name,
        string $description
    ): MainDTOInterface;
}
