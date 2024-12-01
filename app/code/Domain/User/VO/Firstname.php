<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\User\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Firstname
{
    protected const PATTERN = '/^[\p{L}]{3,30}$/u';
    protected const ERROR_MESSAGE = 'First name must be 3-30 characters long, can contain letters';

    public function __construct(
        public readonly string $firstname
    ) {
        if (strlen($firstname) === 0) {
            throw new InvalidArgumentException('firstname is empty');
        }

        $check = preg_match($this::PATTERN, $firstname);
        if ($check === 0 || $check === false) {
            throw new InvalidArgumentException($this::ERROR_MESSAGE);
        }
    }

    public function __invoke(): string
    {
        return $this->firstname;
    }
}
