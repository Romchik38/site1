<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\User\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Username
{
    public const FIELD = 'user_name'; 
    public const PATTERN = '[A-Za-z0-9_]{3,20}$';
    public const ERROR_MESSAGE = 'Username must be 3-20 characters long, can contain lowercase, uppercase letter, number and underscore. Case-Sensitive';

    public function __construct(
        public readonly string $username
    ) {
        if (strlen($username) === 0) {
            throw new InvalidArgumentException('username is empty');
        }

        $check = preg_match('/' . $this::PATTERN . '/', $username);
        if ($check === 0 || $check === false) {
            throw new InvalidArgumentException('Check field: ' . $this::ERROR_MESSAGE);
        }
    }

    public function __invoke(): string
    {
        return $this->username;
    }
}
