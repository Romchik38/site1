<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\PageView;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class FindByUrl
{
    /** @throws InvalidArgumentException */
    public function __construct(
        public readonly string $url
    ) {
        if (strlen($url) === 0) {
            throw new InvalidArgumentException('url is empty');
        }
    }
}
