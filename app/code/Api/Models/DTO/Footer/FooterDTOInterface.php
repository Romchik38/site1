<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\Footer;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface FooterDTOInterface extends DTOInterface
{
    const COPYRIGHTS_TEXT = 'copyrights_text';

    public function getCopyrightsText(): string;
}
