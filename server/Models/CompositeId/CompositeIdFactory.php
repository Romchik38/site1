<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\MenuToLinks;

use Romchik38\Server\Api\Models\CompositeId\CompositeIdModelInterface;
use Romchik38\Server\Models\CompositeId\CompositeIdModel;

class CompositeIdFactory {
    public function create(): CompositeIdModelInterface
    {
        return new CompositeIdModel();
    }
}