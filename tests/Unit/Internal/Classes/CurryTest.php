<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda\Unit\Internal\Classes;

use PHPUnit\Framework\TestCase;
use Tests\Wojciech\Phlambda\Support\ExceptionAssertions;
use Wojciech\Phlambda\Internal\Classes\CurryingFunction;
use Wojciech\Phlambda\Internal\Classes\Placeholder;
use Wojciech\Phlambda\Internal\Exceptions\TooMuchArgumentsGiven;
use function Wojciech\Phlambda\add;
use function Wojciech\Phlambda\curryN;
use const Wojciech\Phlambda\__;

class CurryTest extends TestCase
{
    use ExceptionAssertions;

    public function testCrating_NumberOfRequiredArgumentsGreaterThan0_CurryingFunctionWithPlaceholdersCreated(): void
    {
        $expectedPassedParameters = [Placeholder::create()];
        $someCallable = fn ($a) => $a;
        $expectedNumberOfArguments = 1;

        $curryingFunction = $this->observableCurryingFunction($someCallable, $expectedNumberOfArguments);

        $this->assertCount($expectedNumberOfArguments, $curryingFunction->passedArguments());
        $this->assertEquals($expectedPassedParameters, $curryingFunction->passedArguments());
    }

    public function testCreating_0GivenAsNumberOfRequiredParameters_CurryingFunctionWithoutParametersCreated(): void
    {
        $expectedPassedParameters = [];
        $someCallable = fn ($a) => $a;
        $expectedNumberOfArguments = 0;

        $curryingFunction = $this->observableCurryingFunction($someCallable, $expectedNumberOfArguments);

        $this->assertCount($expectedNumberOfArguments, $curryingFunction->passedArguments());
        $this->assertSame($expectedPassedParameters, $curryingFunction->passedArguments());
    }

    public function testCurrying_MoreThenExpectedNumberOfArgumentsAreGiven_ThrowsInvalidArgumentException(): void
    {
        $expectedNumberOfArguments = 1;
        $someCallableExpectingOneArgument = fn($a) => $a;
        $moreThenOneExpectedArgument = [1,1];
        $curry = curryN($someCallableExpectingOneArgument, $expectedNumberOfArguments);

        $act = fn () => $curry(...$moreThenOneExpectedArgument);

        $expectedException = TooMuchArgumentsGiven::create($expectedNumberOfArguments);
        $this->assertException($expectedException, $act);
    }

    public function testCurrying_LessThenExpectedNumberOfArgumentsGiven_ReturnsCurryingFunction(): void
    {
        $curryFunctionRequiringOneArgument = new CurryingFunction(fn ($x) => $x, 1);

        $resultOfCallingWithoutAnyArgument = $curryFunctionRequiringOneArgument();

        $this->assertInstanceOf(CurryingFunction::class, $resultOfCallingWithoutAnyArgument);
    }

    public function testCurrying_GivePartiallyArguments_AnotherCurryingFunctionIsReturned(): void
    {
        $someCallback = fn($x, $y) => $x . $y;
        $curryingFunctionRequiringTwoArguments = $this->observableCurryingFunction($someCallback, 2);

        $partiallyCalledCurryingFunction = $curryingFunctionRequiringTwoArguments('a');

        $this->assertEquals(['a', Placeholder::create()], $partiallyCalledCurryingFunction->passedArguments());
        $this->assertInstanceOf(CurryingFunction::class, $partiallyCalledCurryingFunction);
        $this->assertNotSame($curryingFunctionRequiringTwoArguments, $partiallyCalledCurryingFunction);
    }

    public function testCurry_GiveNoArguments_SameCurryingFunctionIsReturned(): void
    {
        $curryingFunction = new CurryingFunction(fn ($x) => $x, 1);

        $curryingCalledWithoutArguments = $curryingFunction();

        $this->assertSame($curryingFunction, $curryingCalledWithoutArguments);
    }

    public function testCurry_OnlyPlaceholdersGiven_SameCurryingFunctionIsReturned(): void
    {
        $curryingFunction = new CurryingFunction(fn ($x) => $x, 1);

        $curryingCalledWithPlaceholders = $curryingFunction(__);

        $this->assertSame($curryingFunction, $curryingCalledWithPlaceholders);
    }

    public function testCurry_PlaceholderIsGiven_ArgumentIsOmittedAndNewCurryingFunctionIsReturned(): void
    {
        $currying = new CurryingFunction(fn($a, $b, $c) => $a.$b.$c, 3);
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

    private function observableCurryingFunction(\Closure $someCallable, $expectedNumberOfArguments): CurryingFunction
    {
        return new class($someCallable, $expectedNumberOfArguments) extends CurryingFunction {
            public function passedArguments(): array
            {
                return $this->passedArguments;
            }
        };
    }
}