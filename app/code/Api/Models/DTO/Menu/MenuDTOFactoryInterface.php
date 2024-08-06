<?php

namespace Romchik38\Site1\Api\Models\DTO\Menu;

use Romchik38\Site1\Api\Models\Menu\MenuModelInterface;

/**
 * Creates a menu dto entity with provided values
 */
interface MenuDTOFactoryInterface {
    /**
     * @param int $id [MenuModelInterface id]
     * @param string $name [MenuModelInterface name]
     * @param LinkDTOInterface[] $links
     * @return MenuDTOInterface
     */
    public function create(
        int $id,
        string $name,
        array $links
    ): MenuDTOInterface;
}