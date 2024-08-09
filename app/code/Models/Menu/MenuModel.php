<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Menu;

use Romchik38\Site1\Api\Models\Menu\MenuModelInterface;
use Romchik38\Server\Models\Model;

class MenuModel extends Model implements MenuModelInterface {
    public function getId(): int
    {
        return (int)$this->data[$this::MENU_ID_FILED];
    }

    public function getName(): string {
        return $this->data[$this::MENU_NAME_FILED];
    }

    public function setId(int $id): MenuModelInterface {
        $this->data[$this::MENU_ID_FILED] = $id;
        return $this;
    }

    public function setName(string $name): MenuModelInterface {
        $this->data[$this::MENU_NAME_FILED] = $name;
        return $this;
    }

}