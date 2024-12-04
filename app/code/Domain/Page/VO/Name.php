<?php

namespace Romchik38\Site1\Domain\Page\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Name
{
    public function __construct(
        public readonly string $name
    ) {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('name is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->name;
    }
}
