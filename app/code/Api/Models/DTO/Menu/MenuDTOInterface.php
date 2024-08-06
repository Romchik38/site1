<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Menu;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface MenuDTOInterface extends DTOInterface {
    const ID_FIELD = 'id';
    const NAME_FIELD = 'name';

    public function getId(): int;
    public function getName(): string;

    /**
     * Return array of link entities
     * 
     * @return LinkDTOInterface[]
     */
    public function getLinks(): array;

}