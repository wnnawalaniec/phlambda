<?php
declare(strict_types=1);

namespace Tests\Phlambda\Unit;

use function Phlambda\{dec, divide, inc, multiply, subtract, sum};

class MathTest extends BaseTest
{
    public function testSum(): void
    {
        $this->assertSame(8.9, sum([1, 6.6, 1.3]));
        $this->assertSame(6, sum([1, 2, 3]));
        $this->assertSame(6.0, sum([1, 2.0, 3]));
    }

    public function testDecreasing(): void
    {
        $this->assertSame(6.2, dec(7.2));
        $this->assertSame(6.0, dec(7.0));
        $this->assertSame(6, dec(7));
    }

    public function testIncreasing(): void
    {
        $this->assertSame(8.2, inc(7.2));
        $this->assertSame(8.0, inc(7.0));
        $this->assertSame(8, inc(7));
    }

    public function testDivide(): void
    {
        $this->assertSame(2.721518987341772, divide(6.45, 2.37));
        $this->assertSame(3, divide(6, 2));
        $this->assertSame(3.0, divide(6, 2.0));
        $this->assertSame(3.0, divide(6.0, 2));
    }

    public function testMultiply(): void
    {
        $this->assertSame(15.286500000000002, multiply(6.45, 2.37));
        $this->assertSame(12, multiply(6, 2));
        $this->assertSame(12.0, multiply(6, 2.0));
        $this->assertSame(12.0, multiply(6.0, 2));
    }

    public function testSubtract(): void
    {
        $this->assertSame(2.0, subtract(3.14, 1.14));
        $this->assertSame(2, subtract(3, 1));
        $this->assertSame(2.0, subtract(3, 1.0));
        $this->assertSame(2.0, subtract(3.0, 1));
    }
}