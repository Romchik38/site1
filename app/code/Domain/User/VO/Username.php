<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\User\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Username
{
    public function __construct(
        public readonly string $username
    ) {
        if (strlen($username) === 0) {
            throw new InvalidArgumentException('param username is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->username;
    }
}
