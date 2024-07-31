<?php

namespace Romchik38\Site1\Api\Models\DTO\Header;

use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOInterface;

interface HeaderDTOFactoryInterface {
    public function create(
        string $phoneNumberText,
        string $addressText,
        string $notice,
    ): HeaderDTOInterface;
}