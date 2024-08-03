<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\MenuToLinks;

use Romchik38\Server\Api\Models\ModelInterface;

/** Used in repository getById method */
interface MenuToLinksIdInterface extends ModelInterface {
    const array ID_FIELDS = [
        MenuToLinksInterface::MENU_ID_FIELD => 'integer',
        MenuToLinksInterface::LINK_ID_FIELD => 'integer',
        MenuToLinksInterface::PARRENT_LINK_ID_FIELD => 'integer'
    ];

    public function getKeys(): array;
    
    public function setId(string $key, mixed $value): MenuToLinksIdInterface;
    
}