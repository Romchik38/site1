<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Login;

use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use Romchik38\Site1\Models\DTO\Login\LoginDTO;

class LoginDTOFactory implements LoginDTOFactoryInterface {

    public function create(): LoginDTOInterface {
        return new LoginDTO();
    }
}