<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Login;

final class Message
{
    public const FIELD = 'message';

    protected function __construct(
        public readonly string $message
    ) {}

    public static function fromRequest(array $hash): self
    {
        return new self($hash[self::FIELD] ?? '');
    }

    public function __invoke(): string
    {
        return $this->message;
    }
}
