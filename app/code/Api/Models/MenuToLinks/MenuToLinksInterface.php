<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\MenuToLinks;

use Romchik38\Server\Api\Models\ModelInterface;

interface MenuToLinksInterface extends ModelInterface
{
    const MENU_ID_FIELD = 'menu_id';
    const LINK_ID_FIELD = 'link_id';
    const PARRENT_LINK_ID_FIELD = 'parrent_link_id';
    const PRIORITY_FIELD = 'priority';

    public function getId(): array;
    public function getPriority(): int;

    public function setId(array $id): MenuToLinksInterface;
    public function setPriority(string $priority): MenuToLinksInterface;
}
