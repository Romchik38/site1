<?php

namespace Romchik38\Site1\Api\Models\DTO\Footer;

interface FooterDTOFactoryInterface
{
    public function create(
        string $copyrightsText,
    ): FooterDTOInterface;
}
