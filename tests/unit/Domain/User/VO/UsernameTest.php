<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Site1\Domain\User\VO\Username;

class UsernameTest extends TestCase
{
    public function testUsernameIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Username('');
    }

    public function testPatternTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Username('d2');
    }

    public function testPatternInvalidChars(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Username('+-=()@#%^&?"\'/[]\\.$*1!');
    }

    public function testPatternValid(): void
    {
        $username = new Username('d223_S');
        $this->assertSame('d223_S', $username());
    }
}
