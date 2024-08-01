<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Footer;

use Romchik38\Site1\Api\Models\DTO\Footer\FooterDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Footer\FooterDTOInterface;

class FooterDTOFactory implements FooterDTOFactoryInterface {
    public function create(string $copyrightsText): FooterDTOInterface
    {
        return new FooterDTO($copyrightsText);
    }
}