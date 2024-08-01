<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Menu;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

/**
 * Represents an entity, used in view.
 * It's a menu element 
 */
interface MenuDTOInterface extends DTOInterface
{
    const DESCRIPTION = 'description';
    const NAME = 'name';
    const URL = 'url';

    public function getDescription(): string;
    public function getName(): string;
    public function getUrl(): string;
}
