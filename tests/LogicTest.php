<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use function Wojciech\Phlambda\_and;
use function Wojciech\Phlambda\both;

class LogicTest extends BaseTest
{
    public function testBoth(): void
    {
        $isEven = fn (int$a) => $a % 2 === 0;
        $this->assertSame(true, both('is_integer', $isEven)(2));
        $this->assertSame(false, both('is_integer', $isEven)(1));
        $this->assertSame(false, both('is_integer', $isEven)(1.0));
    }

    public function testAnd(): void
    {
        $this->assertSame(true, _and(true, true));
        $this->assertSame(false, _and(true, false));
    }
}