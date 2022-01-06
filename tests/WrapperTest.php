<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use PHPUnit\Framework\TestCase;
use Wojciech\Phlambda\Wrapper;
use function Wojciech\Phlambda\add;
use function Wojciech\Phlambda\below;
use function Wojciech\Phlambda\inc;
use function Wojciech\Phlambda\_;

class WrapperTest extends TestCase
{
    public function testArrayAccess(): void
    {
        $wrapper = new Wrapper();

        $wrapper[] = 1;
        $this->assertSame([1], $wrapper->toArray());

        unset($wrapper[0]);
        $this->assertEmpty($wrapper->toArray());

        $wrapper['foo'] = 'bar';
        $this->assertTrue(isset($wrapper['foo']));
        $this->assertSame('bar', $wrapper['foo']);
    }

    public function testAny(): void
    {
        $this->assertTrue(_([1,2,3])->any(below(2)));
        $this->assertFalse(_([1,2,3])->any(below(1)));
    }

    public function testAdjust(): void
    {
        $this->assertSame([1, 2, 4], _([1, 2, 3])->adjust(inc(), -1)->toArray());
    }

    public function testAll(): void
    {
        $this->assertTrue(_([1,2,3])->all(below(4)));
        $this->assertFalse(_([1,2,3])->all(below(3)));
    }

    public function testAppend(): void
    {
        $this->assertSame([1, 2, 3, 4], _([1, 2, 3])->append(4)->toArray());
    }

    public function testConcat(): void
    {
        $this->assertSame([1, 2, 'a', 'b'], _([1, 2])->concat(['a', 'b'])->toArray());
        $this->assertSame([1, 2, 'a', 'b'], _([1, 2])->concat(_(['a', 'b']))->toArray());
    }

    public function testDrop(): void
    {
        $this->assertSame([3, 4], _([1, 2, 3, 4])->drop(2)->toArray());
    }

    public function testDropLast(): void
    {
        $this->assertSame([1, 2], _([1, 2, 3, 4])->dropLast(2)->toArray());
    }

    public function testDropRepeats(): void
    {
        $this->assertSame([1, '1', true, 2, 3], _([1, 1, '1', true, 2, 3, 1])->dropRepeats()->toArray());
    }

    public function testMap(): void
    {
        $this->assertSame(['1', '2', '3'], _([1, 2, 3])->map(toString())->toArray());
    }

    public function testReduce(): void
    {
        $this->assertSame(6, _([1, 2, 3])->reduce(add(), 0));
    }
}
