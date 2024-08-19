<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\Page;

use Romchik38\Server\Api\Models\RepositoryInterface;

interface PageRepositoryInterface extends RepositoryInterface {
    public function getByUrl(string $url): array;
    public function getUrls(string $expression = '', array $param = []): array;
}