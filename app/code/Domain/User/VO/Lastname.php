<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\User\VO;

use InvalidArgumentException;

final class Lastname
{
    public const FIELD = 'last_name';
    public const PATTERN = '^[\p{L}]{3,30}$';
    public const ERROR_MESSAGE = 'Last name must be 3-30 characters long, can contain letters';

    /** @throws InvalidArgumentExceptions */
    public function __construct(
        public readonly string $lastname
    ) {
        if (strlen($lastname) === 0) {
            throw new InvalidArgumentException('lastname is empty');
        }

        $check = preg_match('/' . $this::PATTERN . '/u', $lastname);
        if ($check === 0 || $check === false) {
            throw new InvalidArgumentException($this::ERROR_MESSAGE);
        }
    }

    public function __invoke(): string
    {
        return $this->lastname;
    }
}
