<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\PageView\Views;

final class Page
{
    public function __construct(
        public readonly string $content,
        public readonly int $id,
        public readonly string $name,
        public readonly string $url
    ) {}
}
