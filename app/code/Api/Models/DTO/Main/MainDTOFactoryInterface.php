<?php

namespace Romchik38\Site1\Api\Models\DTO\Main;

use Romchik38\Server\Api\Models\DTOFactoryInterface;

interface MainDTOFactoryInterface extends DTOFactoryInterface {
    public function create(): MainDTOInterface;
}