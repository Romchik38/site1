<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\User\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Password
{
    public function __construct(
        public readonly string $password
    ) {
        if (strlen($password) === 0) {
            throw new InvalidArgumentException('param password is empy');
        }
    }

    public function __invoke(): string
    {
        return $this->password;
    }
}
