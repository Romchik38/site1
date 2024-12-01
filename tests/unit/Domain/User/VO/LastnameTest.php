<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site1\Domain\User\VO\Lastname;

class LastnameTest extends TestCase
{
    public function testLastnameIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Lastname('');
    }

    public function testPatternTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Lastname('Dy');
    }

    public function testPatternInvalidCharsNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Lastname('Dim9');
    }

    public function testPatternValid(): void
    {
        $lastname = new Lastname('Dim');
        $this->assertSame('Dim', $lastname());
    }
}
