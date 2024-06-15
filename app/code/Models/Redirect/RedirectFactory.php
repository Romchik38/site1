<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Redirect;

use Romchik38\Site1\Models\Redirect\RedirectModel;
use Romchik38\Site1\Api\Models\RedirectModelInterface;
use Romchik38\Server\Api\Models\ModelFactoryInterface;

class RedirectFactory implements ModelFactoryInterface {
    public function create(): RedirectModelInterface {
        return new RedirectModel();
    }
}