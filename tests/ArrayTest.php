<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\ShouldNotBeImplementedInWrapper;
use Wojciech\Phlambda\Wrapper;
use function Wojciech\Phlambda\{_,
    above,
    adjust,
    all,
    any,
    append,
    below,
    clamp,
    concat,
    drop,
    dropLast,
    dropLastWhile,
    dropRepeats,
    filter,
    flat,
    flatMap,
    map,
    multiply,
    reduce};
use const Wojciech\Phlambda\_;
use const Wojciech\Phlambda\add;
use const Wojciech\Phlambda\concat;
use const Wojciech\Phlambda\inc;
use const Wojciech\Phlambda\toString;

class ArrayTest extends BaseTest
{
    public function testAdjust(): void
    {
        $this->assertSame([1, 2, 4], adjust(inc, -1, [1, 2, 3]));
        $this->assertSame([1, 2, 4], adjust(inc, 2, [1, 2, 3]));
        $this->assertSame([1, 2, 3], adjust(inc, 3, [1, 2, 3]));
        $this->assertSame([1, 2, 3], adjust()(inc)(3)([1, 2, 3]));
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

    public function testDropLastWhile(): void
    {
        $this->assertSame([1, 2, 3, 4], dropLastWhile(below(4), [1, 2, 3, 4, 3, 2, 1]));
        $this->assertSame([6 => 0, 1, 2, 3, 0 => 4], dropLastWhile(below(4), [6 => 0, 1, 2, 3, 0=> 4, 3, 2, 1]));
        $this->assertSame([4, 5, 6], dropLastWhile(below(4), [4, 5, 6]));
        $this->assertSame('abcdef', dropLastWhile(fn($x) => $x !== 'f', 'abcdefedcba'));
        $this->assertSame('', dropLastWhile(fn($x) => $x !== 'z', 'abc'));
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

    public function testFilter(): void
    {
        $this->assertSame([1, 2], filter(below(3), [1, 2, 3]));
    }

    public function testFlatMap(): void
    {
        $duplicate = fn ($x) => [$x, $x];
        $this->assertSame([2, 4, 6], flatMap(multiply(2), [1, 2, 3]));
        $this->assertSame([1, 1, 2, 2, 3, 3], flatMap($duplicate, [1, 2, 3]));
        $this->assertSame([1, 1, 2, 2, 3, 3], flatMap($duplicate, [1, [[2]], [3]]));
    }

    public function testFlat(): void
    {
        $this->assertSame([1, 2, 3], flat(false, [1, 2, 3]));
        $this->assertSame([1, 2, 3], flat(true, [1, 2, 3]));
        $this->assertSame([1, 2, 3], flat(false, [[1], [2], [3]]));
        $this->assertSame([1, 2, 3], flat(true, [[1], [2], [3]]));
        $this->assertSame([[1], [2], [3]], flat(false, [[[1]], [[2]], [[3]]]));
        $this->assertSame([1, 2, 3], flat(true, [[[1]], [[2]], [[3]]]));
    }

    public function testMap(): void
    {
        $this->assertSame(['1', '2', '3'], map(toString, [1, 2, 3]));
    }

    public function testReduce(): void
    {
        $this->assertEquals('abc', reduce(concat, null, ['a', 'b', 'c']));
        $this->assertEquals('a', reduce(concat, null, ['a']));
        $this->assertEquals('ab', reduce(concat, 'a', ['b']));
        $this->assertEquals('a', reduce(concat, 'a', []));
        $this->assertEquals(6, reduce(add, 0, [1, 2, 3]));
    }

    public function testReduce_EmptyArrayAndNoInitialValueGiven_ThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        reduce(concat, null, []);
    }

    public function testWrap(): void
    {
        $this->assertEquals(Wrapper::wrap([1, 2, 3]), _([1, 2, 3]));
    }

    public function testWrapShouldNotBeImplementedInWrapper(): void
    {
        $this->assertFunctionHasAttribute(ShouldNotBeImplementedInWrapper::class, _);
    }
}