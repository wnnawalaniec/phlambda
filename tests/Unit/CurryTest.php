<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda\Unit;

use Tests\Wojciech\Phlambda\Support\ExceptionAssertions;
use function Wojciech\Phlambda\curry;
use function Wojciech\Phlambda\curry2;
use function Wojciech\Phlambda\curry3;

class CurryTest extends BaseTest
{
    use ExceptionAssertions;

    public function testCurry(): void
    {
        $curry = curry(fn ($a) => $a + 1);
        $this->assertSame(2, $curry(1));
        $this->assertSame(2, $curry()(1));
    }

    public function testCurry2(): void
    {
        $curry = curry2(fn ($a, $b) => $a . $b);
        $this->assertSame('ab', $curry('a', 'b'));
        $this->assertSame('ab', $curry()('a')('b'));
        $this->assertSame('ab', $curry()('a', 'b'));
    }

    public function testCurry3(): void
    {
        $curry = curry3(fn ($a, $b, $c) => $a . $b . $c);
        $this->assertSame('abc', $curry('a', 'b', 'c'));
        $this->assertSame('abc', $curry()('a')('b')('c'));
        $this->assertSame('abc', $curry()('a', 'b', 'c'));
    }
}