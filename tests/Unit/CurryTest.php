<?php
declare(strict_types=1);

namespace Tests\Phlambda\Unit;

use Tests\Phlambda\Support\ExceptionAssertions;
use Tests\Phlambda\Support\ClassToCall;
use function Phlambda\curry;
use function Phlambda\curry1;
use function Phlambda\curry2;
use function Phlambda\curry3;
use const Phlambda\__;
use const Phlambda\inc;

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
        $this->assertSame('a', curry($someCallback)('a'));
    }

    public function testCurring_ClosureGiven_CurringFunctionReturned(): void
    {
        $closure = new class() { public function __invoke($a) {return $a; }};
        $this->assertSame('a', curry($closure)('a'));
    }

    public function testCurring_StringWithFunctionNameGiven_CurringFunctionReturned(): void
    {
        $this->assertSame(2, curry(inc)(1));
    }

    public function testCurring_ArrayFunctionGiven_CurringFunctionReturned(): void
    {
        $this->assertSame('call', curry([new ClassToCall(), 'call'])());
        $this->assertSame('static', curry([new ClassToCall(), 'staticCall'])());
        $this->assertSame('static', curry('\Tests\Phlambda\Support\ClassToCall::staticCall')());
        $this->assertSame('static', curry([ClassToCall::class, 'staticCall'])());
    }

    public function testPlaceholders(): void
    {
        $currying = curry3(fn($a, $b, $c) => $a.$b.$c);
        $this->assertSame('abc', $currying(__, __, __)('a', 'b', 'c'));
        $this->assertSame('abc', $currying(__, __, __)('a', 'b', 'c'));
        $this->assertSame('abc', $currying(__, __, __)('a')('b')('c'));
        $this->assertSame('abc', $currying(__, 'b', 'c')('a'));
        $this->assertSame('abc', $currying('a', __, 'c')('b'));
        $this->assertSame('abc', $currying('a', 'b', __)('c'));
        $this->assertSame('abc', $currying(__, 'b', __)('a', 'c'));
        $this->assertSame('abc', $currying(__, 'b')('a', 'c'));
        $this->assertSame('abc', $currying(__, 'b')('a')('c'));
        $this->assertSame('abc', $currying(__, 'b')(__, 'c')('a'));
    }
}