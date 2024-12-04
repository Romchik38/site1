<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\Page;

use Romchik38\Server\Models\ModelFactory;

class PageFactory extends ModelFactory
{
    public function create(): PageModel
    {
        return new PageModel();
    }
}
