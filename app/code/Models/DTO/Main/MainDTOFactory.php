<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Main;

use Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Main\MainDTOInterface;
use Romchik38\Site1\Application\PageView\Views\Page;

class MainDTOFactory implements MainDTOFactoryInterface
{

    public function create(
        Page $page,
        string $name,
        string $description
    ): MainDTOInterface {
        return new MainDTO(
            $page,
            $name,
            $description
        );
    }
}
