<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Menu;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\Menu\MenuDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Menu\LinkDTOInterface;

class MenuDTO extends DTO implements MenuDTOInterface
{

    /**
     * @param int $id [MenuModelInterface id]
     * @param string $name [MenuModelInterface name]
     * @param LinkDTOInterface[] $links [0 level links]
     * @return MenuDTOInterface
     */
    public function __construct(
        int $id,
        string $name,
        protected array $links
    ) {
        $this->data[MenuDTOInterface::ID_FIELD] = $id;
        $this->data[MenuDTOInterface::NAME_FIELD] = $name;
        

    }
    public function getId(): int
    {
        return $this->data[MenuDTOInterface::ID_FIELD];
    }

    public function getName(): string
    {
        return $this->data[MenuDTOInterface::NAME_FIELD];
    }

    public function getLinks(): array
    {
        return $this->links;
    }
}
