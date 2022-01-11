<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\ShouldNotBeImplementedInWrapper;

/**
 * Returns currying function awaiting 3 arguments.
 *
 * @param callable $fn Callable accepting exactly 3 parameters.
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function curry3(callable $fn): callable
{
    return $fn2 = function (...$v) use ($fn, &$fn2) {
        return match (func_num_args()) {
            0 => $fn2,
            1 => curry2(fn (...$_v) => $fn(...$v, ...$_v)),
            2 => curry(fn (...$_v) => $fn(...$v, ...$_v)),
            3 => $fn(...$v),
        };
    };
}

const curry3 = '\Wojciech\Phlambda\curry3';

/**
 * Returns currying function awaiting 2 arguments.
 *
 * @param callable $fn Callable accepting exactly 2 parameters.
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function curry2(callable $fn): callable
{
    return $fn2 = function (...$v) use ($fn, &$fn2) {
          return match (func_num_args()) {
              0 => $fn2,
              1 => curry(fn (...$_v) => $fn(...$v, ...$_v)),
              2 => $fn(...$v)
          };
    };
}

const curry2 = '\Wojciech\Phlambda\curry2';

/**
 * Returns currying function awaiting 1 argument.
 *
 * @param callable $fn Callable accepting exactly 1 parameter.
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function curry(callable $fn): callable
{
    return $fn2 = function (...$v) use ($fn, &$fn2) {
        return match (func_num_args()) {
            0 => $fn2,
            1 => $fn(...$v)
        };
    };
}

const curry = '\Wojciech\Phlambda\curry';