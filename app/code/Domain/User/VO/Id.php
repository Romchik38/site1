<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\User\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Id
{
    public function __construct(
        public readonly int $id
    ) {
        if ($id === 0) {
            throw new InvalidArgumentException('id is invalid');
        }
    }

    public function __invoke(): int
    {
        return $this->id;
    }
}
