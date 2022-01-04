<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    public function testSum(): void
    {
        $array = [1, 6.6, '1.3', true, null];

        $sum = sum($array);

        $expectedValue = 9.9;
        $this->assertSame($expectedValue, $sum);
    }

    public function testDecreasing(): void
    {
        $value = 7.2;

        $decreased = dec($value);

        $expected = 6.2;
        $this->assertSame($expected, $decreased);
    }

    public function testIncreasing(): void
    {
        $value = 7.2;

        $decreased = inc($value);

        $expected = 8.2;
        $this->assertSame($expected, $decreased);
    }

    public function testDivide(): void
    {
        $a = 6.45;
        $b = 2.37;

        $value = divide($a, $b);

        $expectedValue = 2.721518987341772;
        $this->assertSame($expectedValue, $value);
    }

    public function testMultiply(): void
    {
        $a = 6.45;
        $b = 2.37;

        $value = multiply($a, $b);

        $expectedValue = 15.286500000000002;
        $this->assertSame($expectedValue, $value);
    }
}