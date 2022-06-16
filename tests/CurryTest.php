<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\Exceptions\TooMuchArgumentsGiven;
use function Wojciech\Phlambda\curry;
use function Wojciech\Phlambda\curry2;
use function Wojciech\Phlambda\curry3;
use function Wojciech\Phlambda\curryN;

class CurryTest extends BaseTest
{
    public function testCurry(): void
    {
        $curry = curry(fn ($a) => $a + 1);
        $this->assertSame(2, $curry(1));
        $this->assertSame(2, $curry()(1));
    }

    public function testCurry_MoreThenExpectedNumberOfArgumentsAreGiven_ThrowsInvalidArgumentException(): void
    {
        $expectedNumberOfArguments = 1;
        $someCallableExpectingOneArgument = fn($a) => $a;
        $moreThenOneExpectedArgument = [1,1];
        $curry = curryN($someCallableExpectingOneArgument, $expectedNumberOfArguments);

        $act = fn () => $curry(...$moreThenOneExpectedArgument);

        $expectedException = TooMuchArgumentsGiven::create($expectedNumberOfArguments);
        $this->assertException($expectedException, $act);
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

    private function assertException(\Exception $expectedException, callable $act): void
    {
        $this->expectExceptionObject($expectedException);
        $act();
    }
}