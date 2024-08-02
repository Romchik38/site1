<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\Menu;

use Romchik38\Server\Api\Models\ModelInterface;

interface MenuModelInterface extends ModelInterface {
    const MENU_ID_FILED = 'menu_id';
    const MENU_NAME_FILED = 'name';

    public function getId(): int;
    public function getName(): string;
}