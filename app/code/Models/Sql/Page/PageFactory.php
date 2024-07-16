<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\Page;

use Romchik38\Server\Models\ModelFactory;
use Romchik38\Site1\Models\Sql\Page\PageModel;

class PageFactory extends ModelFactory
{
    public function create(): PageModel
    {
        return new PageModel();
    }
}
