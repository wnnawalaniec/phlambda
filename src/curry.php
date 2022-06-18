<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\Attributes\ShouldNotBeImplementedInWrapper;
use Wojciech\Phlambda\Internal\Classes\CurryingFunction;
use Wojciech\Phlambda\Internal\Classes\Placeholder;

/**
 * Returns n currying function.
 *
 * @param callable $callback callable accepting $n elements
 * @param int $numberOfExpectedArguments number of arguments accepted by given $fn function
 */
#[ShouldNotBeImplementedInWrapper]
function curryN(callable $callback, int $numberOfExpectedArguments): callable
{
    return new CurryingFunction($callback, $numberOfExpectedArguments);
}

/**
 * Returns currying function awaiting 3 arguments.
 *
 * @param callable $fn Callable accepting exactly 3 parameters.
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function curry3(callable $fn): callable
{
    return curryN($fn, 3);
}

/**
 * Returns currying function awaiting 2 arguments.
 *
 * @param callable $fn Callable accepting exactly 2 parameters.
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function curry2(callable $fn): callable
{
    return curryN($fn, 2);
}

/**
 * Returns currying function awaiting 1 argument.
 *
 * @param callable $fn Callable accepting exactly 1 parameter.
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function curry(callable $fn): callable
{
    return curryN($fn, 1);
}

/**
 * Returns placeholder for omitting some arguments in currying functions.
 */
#[ShouldNotBeImplementedInWrapper]
function __(): Placeholder
{
    return Placeholder::create();
}