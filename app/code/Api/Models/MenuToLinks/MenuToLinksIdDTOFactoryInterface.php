<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\MenuToLinks;

use Romchik38\Server\Models\Errors\DTO\CantCreateDTOException;

interface MenuToLinksIdDTOFactoryInterface
{
    /**
     * Create an Id DTO entity with provided array of values 
     * 
     * @param array $data [$key => $value, ...]
     * @throws CantCreateDTOException [if not enough keys are provided]
     * @return MenuToLinksIdDTOInterface
     */
    public function create(
        array $data
    ): MenuToLinksIdDTOInterface;
}
