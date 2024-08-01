<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Footer;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\Footer\FooterDTOInterface;

class FooterDTO extends DTO implements FooterDTOInterface {
    public function getCopyrightsText(): string
    {
        return $this->data[$this::COPYRIGHTS_TEXT];
    }
}