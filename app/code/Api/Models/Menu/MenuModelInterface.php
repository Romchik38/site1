<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\Menu;

use Romchik38\Server\Api\Models\ModelInterface;

interface MenuModelInterface extends ModelInterface {
    const MENU_ID_FILED = 'menu_id';
    const MENU_NAME_FILED = 'name';

    public function getId(): int;
    public function getName(): string;

    public function setId(int $id): MenuModelInterface;
    public function setName(string $name): MenuModelInterface;
}