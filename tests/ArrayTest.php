<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use PHPUnit\Framework\TestCase;
use Wojciech\Phlambda\Wrapper;
use function Wojciech\Phlambda\{_,
    above,
    add,
    adjust,
    all,
    any,
    append,
    below,
    concat,
    drop,
    dropLast,
    dropRepeats,
    inc,
    map,
    reduce,
    toString};

class ArrayTest extends TestCase
{
    public function testAdjust(): void
    {
        $this->assertSame([1, 2, 4], adjust(inc(), -1, [1, 2, 3]));
        $this->assertSame([1, 2, 4], adjust(inc(), 2, [1, 2, 3]));
        $this->assertSame([1, 2, 3], adjust(inc(), 3, [1, 2, 3]));
        $this->assertSame([1, 2, 3], adjust()(inc())(3)([1, 2, 3]));
    }

    public function testAll(): void
    {
        $array = [9.99, 10, 10.01];

        $this->assertFalse(all(above(10.01), $array));
        $this->assertTrue(all(below(10.02), $array));
    }

    public function testAny(): void
    {
        $array = [9.99, 10, 10.01];

        $this->assertFalse(any(above(10.01), $array));
        $this->assertTrue(any(below(10.00), $array));
    }


    /** @dataProvider allTypesOfValuesProvider */
    public function testAppend(mixed $value): void
    {
        $array = [1, 2, 3];
        $expectedArray = [1, 2, 3, $value];

        $appendedArray = append($value, $array);
        $this->assertSame($expectedArray, $appendedArray);
    }

    public function allTypesOfValuesProvider(): array
    {
        return [
            [1],
            [1.1],
            [true],
            [false],
            [null],
            [['t']],
            ['t'],
            [new \stdClass()],
            [fn () => 'a'],
            [[]]
        ];
    }

    public function testConcat(): void
    {
        $this->assertSame('ab', concat('a', 'b'));
        $this->assertSame(['a', 'b'], concat(['a'], ['b']));
        $this->assertSame([], concat([], []));
        $this->assertEquals('ab', concat()('a')('b'));
        $this->assertEquals('ab', concat('a')('b'));
        $this->assertEquals('ab', concat('a', 'b'));
    }

    public function testConcat_ArgumentsAreOfDifferentTypes_ThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        concat(['a'], 'b');
    }

    public function testDrop(): void
    {
        $this->assertSame('łć', drop(2, 'żółć'));
        $this->assertSame('', drop(4, 'żółć'));
        $this->assertSame('żółć', drop(-1, 'żółć'));
        $this->assertSame([3], drop(2, [1, 2, 3]));
        $this->assertSame([], drop(4, [1, 2, 3]));
        $this->assertSame([1, 2, 3], drop(-1, [1, 2, 3]));
    }

    public function testDropLast(): void
    {
        $this->assertSame('żó', dropLast(2, 'żółć'));
        $this->assertSame('', dropLast(4, 'żółć'));
        $this->assertSame('żółć', dropLast(-1, 'żółć'));
        $this->assertSame([1], dropLast(2, [1, 2, 3]));
        $this->assertSame([], dropLast(4, [1, 2, 3]));
        $this->assertSame([1, 2, 3], dropLast(-1, [1, 2, 3]));
    }

    public function testDropRepeats(): void
    {
        $this->assertSame([1, 2, 3], dropRepeats([1, 1, 2, 2, 3, 3]));
        $this->assertSame([1, 2, 3], dropRepeats([1, 1, 2, 2, 3, 3]));
        $this->assertSame([], dropRepeats([]));
        $this->assertSame([1, '1', true], dropRepeats([1, '1', true]));
        $this->assertSame([[1]], dropRepeats([[1], [1]]));
        $object = new \stdClass();
        $this->assertSame([$object], dropRepeats([$object, $object]));
    }

    public function testMap(): void
    {
        $this->assertSame(['1', '2', '3'], map(toString(), [1, 2, 3]));
    }

    public function testReduce(): void
    {
        $this->assertEquals('abc', reduce(concat(), null, ['a', 'b', 'c']));
        $this->assertEquals('a', reduce(concat(), null, ['a']));
        $this->assertEquals('ab', reduce(concat(), 'a', ['b']));
        $this->assertEquals('a', reduce(concat(), 'a', []));
        $this->assertEquals(6, reduce(add(), 0, [1, 2, 3]));
    }

    public function testReduce_EmptyArrayAndNoInitialValueGiven_ThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        reduce(concat(), null, []);
    }

    public function testWrap(): void
    {
        $this->assertEquals(Wrapper::wrap([1, 2, 3]), _([1, 2, 3]));
    }
}