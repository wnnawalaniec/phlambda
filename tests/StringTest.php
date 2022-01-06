<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use PHPUnit\Framework\TestCase;

class StringTest extends TestCase
{
    public function testToString(): void
    {
        $stringable = new class () implements \Stringable {
            public function __toString(): string
            {
                return '1';
            }
        };
        $this->assertSame('1', toString(1));
        $this->assertSame('1', toString(true));
        $this->assertSame('', toString(null));
        $this->assertSame('1', toString($stringable));
    }
}