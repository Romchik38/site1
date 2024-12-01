<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\User\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Lastname
{
    protected const PATTERN = '/^[\p{L}]{3,30}$/u';
    protected const ERROR_MESSAGE = 'Last name must be 3-30 characters long, can contain letters';

    public function __construct(
        public readonly string $lastname
    ) {
        if (strlen($lastname) === 0) {
            throw new InvalidArgumentException('lastname is empty');
        }

        $check = preg_match($this::PATTERN, $lastname);
        if ($check === 0 || $check === false) {
            throw new InvalidArgumentException('Check field: ' . $this::ERROR_MESSAGE);
        }
    }

    public function __invoke(): string
    {
        return $this->lastname;
    }
}
