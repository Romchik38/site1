<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Menu;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;

class MenuDTO extends DTO implements MenuDTOInterface
{
    /**
     * @param int $id [MenuModelInterface id]
     * @param string $name [MenuModelInterface name]
     * @param LinkDTOInterface[] $links
     * @return MenuDTOInterface
     */
    public function __construct(
        int $id,
        string $name,
        array $links
    ) {
        $this[MenuDTOInterface::ID_FIELD] = $id;
        $this[MenuDTOInterface::NAME_FIELD] = $name;
    }
    public function getId(): int
    {
    }

    public function getName(): string
    {
    }

    public function getLinks(): array
    {
    }
}
