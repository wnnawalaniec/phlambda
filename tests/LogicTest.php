<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use function Wojciech\Phlambda\_and;
use function Wojciech\Phlambda\both;
use function Wojciech\Phlambda\either;

class LogicTest extends BaseTest
{
    public function testAnd(): void
    {
        $this->assertSame(true, _and(true, true));
        $this->assertSame(false, _and(true, false));
    }

    public function testBoth(): void
    {
        $isEven = fn (int$a) => $a % 2 === 0;
        $this->assertSame(true, both('is_integer', $isEven)(2));
        $this->assertSame(false, both('is_integer', $isEven)(1));
        $this->assertSame(false, both('is_integer', $isEven)(1.0));
    }

    public function testEither(): void
    {
        $this->assertSame(true, either('is_integer', 'is_string')(2));
        $this->assertSame(true, either('is_integer', 'is_string')('2'));
        $this->assertSame(false, either('is_integer', 'is_string')(1.0));
    }
}