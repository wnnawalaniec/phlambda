<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use PHPUnit\Framework\TestCase;
use function Wojciech\Phlambda\{
    all,
    below,
    reduce,
    concat
};

class ArrayTest extends TestCase
{
    public function testAll_NotAllMatchesPredicate_ReturnsFalse(): void
    {
        $array = [9.99, 10, 10.01];

        $value = all(below(10), $array);

        $this->assertFalse($value);
    }

    public function testAll_AllMatchesPredicate_ReturnsTrue(): void
    {
        $array = [9.99, 10, 10.01];

        $value = all(below(10.02), $array);

        $this->assertTrue($value);
    }

    public function testReduce_MultipleElementsArrayGiven_ReturnReducedValue(): void
    {
        $array = ['a', 'b', 'c'];
        $expectedValue = 'abc';

        $value = reduce(concat(), null, $array);

        $this->assertEquals($expectedValue, $value);
    }

    public function testReduce_SingleElementArrayGiven_ReturnReducedValue(): void
    {
        $array = ['a'];
        $expectedValue = 'a';

        $value = reduce('Wojciech\Phlambda\concat', null, $array);

        $this->assertEquals($expectedValue, $value);
    }

    public function testReduce_ArrayAndInitialValueGiven_ReturnReducedValue(): void
    {
        $array = ['b'];
        $initialValue = 'a';
        $expectedValue = 'ab';

        $value = reduce(concat(), $initialValue, $array);

        $this->assertEquals($expectedValue, $value);
    }

    public function testReduce_EmptyArrayAndNoInitialValueGiven_ThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        reduce(concat(), null, []);
    }

    public function testReduce_EmptyArrayWithAnInitialValueGiven_ReturnReducedValue(): void
    {
        $initialValue = $expectedValue = 'a';

        $value = reduce(concat(), $initialValue, []);

        $this->assertSame($expectedValue, $value);
    }

    public function testReduce_NoValueGiven_ReturnReducedValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $array = [];

        reduce(concat(), null, $array);
    }

    public function testConcat_StringsGiven_ReturnString(): void
    {
        $a = 'a';
        $b = 'b';
        $expectedValue = 'ab';

        $value = concat($a, $b);

        $this->assertSame($expectedValue, $value);
    }

    public function testConcat_FirstArgumentIsNull_ReturnString(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        concat(null, 'b');
    }

    public function testConcat_SecondArgumentIsNull_ReturnString(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        concat('a', null);
    }

    public function testConcat_ArraysGiven_ReturnArray(): void
    {
        $a = ['a'];
        $b = ['b'];
        $expectedValue = ['a', 'b'];

        $value = concat($a, $b);

        $this->assertSame($expectedValue, $value);
    }

    public function testConcat_Curring(): void
    {
        $this->assertEquals('ab', concat()('a')('b'));
        $this->assertEquals('ab', concat('a')('b'));
        $this->assertEquals('ab', concat('a', 'b'));
    }
}