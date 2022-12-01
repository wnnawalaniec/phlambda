<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda\Unit;

use Tests\Wojciech\Phlambda\Support\ExceptionAssertions;
use function Wojciech\Phlambda\curry;
use function Wojciech\Phlambda\curry1;
use function Wojciech\Phlambda\curry2;
use function Wojciech\Phlambda\curry3;
use const Wojciech\Phlambda\curry;
use const Wojciech\Phlambda\inc;

class CurryTest extends BaseTest
{
    use ExceptionAssertions;

    public function testCurry1(): void
    {
        $curry = curry1(fn ($a) => $a + 1);
        $this->assertSame(2, $curry(1));
        $this->assertSame(2, $curry()(1));
    }

    public function testCurry2(): void
    {
        $curry = curry2(fn ($a, $b) => $a . $b);
        $this->assertSame('ab', $curry('a', 'b'));
        $this->assertSame('ab', $curry('a')('b'));
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

    public function testCurring_AnonymousFunctionGiven_CurringFunctionReturned(): void
    {
        $someCallback = fn ($a) => $a;

        $curryingFunction = curry($someCallback);

        $this->assertSame('a', $curryingFunction('a'));
    }

    public function testCurring_ClosureGiven_CurringFunctionReturned(): void
    {
        $closure = new class() { public function __invoke($a) {return $a; }};

        $curryingFunction = curry($closure);

        $this->assertSame('a', $curryingFunction('a'));
    }

    public function testCurring_StringWithFunctionNameGiven_CurringFunctionReturned(): void
    {
        $string = inc;

        $curryingFunction = curry($string);

        $this->assertSame(2, $curryingFunction(1));
    }
}