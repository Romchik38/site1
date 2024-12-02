<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\RecoveryEmail\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site1\Domain\RecoveryEmail\RecoveryEmailInterface;

final class Hash
{ 
    public const HASH_LENGTH = 20;
    
    protected function __construct(
        public readonly string $hash
    ) {
        if (strlen($hash) !== self::HASH_LENGTH) {
            throw new InvalidArgumentException('email is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->hash;
    }

    public static function create(): self{
        return new self(
            base64_encode(random_bytes(self::HASH_LENGTH))
        );
    }
}
