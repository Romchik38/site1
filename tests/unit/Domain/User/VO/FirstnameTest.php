<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site1\Domain\User\VO\Firstname;

class FirstnameTest extends TestCase
{
    public function testFirstnameIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Firstname('');
    }

    public function testPatternTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Firstname('Dy');
    }

    public function testPatternInvalidCharsNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Firstname('Dim9');
    }

    public function testPatternValid(): void
    {
        $firstname = new Firstname('Dim');
        $this->assertSame('Dim', $firstname());
    }
}
