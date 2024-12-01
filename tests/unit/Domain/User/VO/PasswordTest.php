<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site1\Domain\User\VO\Password;

class PasswordTest extends TestCase
{
    public function testPasswordIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Password('');
    }

    public function testPatternTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Password('d2D_');
    }

    public function testPatternInvalidChars(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Password('d2D______+');
    }

    public function testPatternValid(): void
    {
        $password = new Password('d223_Sa4');
        $this->assertSame('d223_Sa4', $password());
    }
}
