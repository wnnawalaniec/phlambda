<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use PHPUnit\Framework\TestCase;
use Wojciech\Phlambda\Classes\ArrayWrapper;
use Wojciech\Phlambda as f;

class ArrayTest extends TestCase
{
    public function testAll_ValuesMatchesPredicateType_ReturnValue(): void
    {
        $array = [9.99, 10, 10.01, '9.98', null];

        $value = f\all($array, f\below(10));

        $expectedValue = [0 => 9.99, 3 => '9.98'];
        $this->assertSame($expectedValue, $value);
    }

    public function testAll_ValuesDontMatchPredicateType_ValuesIgnored(): void
    {
        $array = ['', null, false];

        $value = f\all($array, f\below(1));

        $this->assertEmpty($value);
    }

    public function testMap(): void
    {
        $array = [1, 2, 3];
        $toString = fn ($x) => (string) $x;

        $value = f\map($array, $toString);

        $expectedValue = ['1', '2', '3'];
        $this->assertSame($expectedValue, $value);
    }

    public function testArr(): void
    {
        $array = [1, 2.2, '3.0'];

        $value = f\arr($array);

        $expectedValue = ArrayWrapper::wrap($array);
        $this->assertEquals($expectedValue, $value);
    }
}