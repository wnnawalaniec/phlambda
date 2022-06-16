<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\Classes\Curry;
use Wojciech\Phlambda\Internal\Attributes\ShouldNotBeImplementedInWrapper;

/**
 * Returns n currying function.
 *
 * @param callable $fn callable accepting $n elements
 * @param int $n number of arguments accepted by given $fn function
 */
#[ShouldNotBeImplementedInWrapper]
function curryN(callable $fn, int $n): callable {
    return new Curry($fn, $n);
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