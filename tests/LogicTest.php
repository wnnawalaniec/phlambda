<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use function Wojciech\Phlambda\_and;
use function Wojciech\Phlambda\_or;
use function Wojciech\Phlambda\above;
use function Wojciech\Phlambda\below;
use function Wojciech\Phlambda\both;
use function Wojciech\Phlambda\either;
use function Wojciech\Phlambda\neither;
use function Wojciech\Phlambda\not;

class LogicTest extends BaseTest
{
    public function testAnd(): void
    {
        $this->assertSame(true, _and(true, true));
        $this->assertSame(false, _and(true, false));
        $this->assertSame(false, _and(false, false));
        $this->assertSame(false, _and(false, false));
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

    public function testNot(): void
    {
        $this->assertSame(true, not(false));
        $this->assertSame(false, not(true));
    }

    public function testNeither(): void
    {
        $this->assertSame(false, neither('is_integer', 'is_string')(2));
        $this->assertSame(false, neither('is_integer', 'is_string')('2'));
        $this->assertSame(true, neither('is_integer', 'is_string')(1.0));
        $this->assertSame(true, neither(above(5), below(3))(4));
    }

    public function testOr(): void
    {
        $this->assertSame(true, _or(true, true));
        $this->assertSame(true, _or(true, false));
        $this->assertSame(false, _or(false, false));
        $this->assertSame(true, _or(false, true));
    }
}