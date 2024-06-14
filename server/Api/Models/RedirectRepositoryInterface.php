<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models;

interface RedirectRepositoryInterface extends RepositoryInterface
{
    public function checkUrl(string $url): string;
}
