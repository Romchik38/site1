<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO;

use Romchik38\Site1\Api\Models\DTO\LoginDtoFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\LoginDtoInterface;
use Romchik38\Site1\Models\DTO\LoginDto;

class LoginDtoFactory implements LoginDtoFactoryInterface {

    public function create(): LoginDtoInterface {
        return new LoginDto();
    }
}