<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models;

use Romchik38\Site1\Api\Models\EntityModelInterface;

interface EntityFactoryInterface {
    public function create(): EntityModelInterface;
}