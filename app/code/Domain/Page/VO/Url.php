<?php

namespace Romchik38\Site1\Domain\Page\VO;

use InvalidArgumentException;

final class Url
{
    public function __construct(
        public readonly string $url
    ) {
        if (strlen($url) === 0) {
            throw new InvalidArgumentException('url is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->url;
    }
}
