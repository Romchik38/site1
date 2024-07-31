<?php

namespace Romchik38\Site1\Models\DTO\Header;

use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOFactoryInterface;
use Romchik38\Site1\Models\DTO\Header\HeaderDTO;

class HeaderDTOFactory implements HeaderDTOFactoryInterface
{
    public function create(string $phoneNumberText, string $addressText, string $notice): HeaderDTO
    {
        return new HeaderDTO($phoneNumberText, $addressText, $notice);
    }
}
