<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO;

use Romchik38\Server\Api\Models\DTOFactoryInterface;

class UserRegisterDTOFactory implements DTOFactoryInterface {

    public function create(): UserRegisterDTO
    {
        return new UserRegisterDTO();
    }
}