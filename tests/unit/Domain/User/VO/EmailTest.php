<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site1\Domain\User\VO\Email;

class EmailTest extends TestCase
{
    public function testEmailIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('');
    }

    public function testLastPartTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('name@domain.c');
    }

    public function testLocalInvalidCharsHyphen(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('Dim9-@domain.com');
    }

    public function testPatternValid(): void
    {
        $email = new Email('Dim.Gen@domain.com');
        $this->assertSame('Dim.Gen@domain.com', $email());
    }
}
