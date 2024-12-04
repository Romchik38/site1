<?php

namespace Romchik38\Site1\Domain\Page\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Content
{
    public function __construct(
        public readonly string $content
    ) {
        if (strlen($content) === 0) {
            throw new InvalidArgumentException('content is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->content;
    }
}
