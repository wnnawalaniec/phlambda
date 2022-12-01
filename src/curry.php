<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use ReflectionFunction;
use ReflectionMethod;
use ReflectionObject;
use Wojciech\Phlambda\Internal\Attributes\ShouldNotBeImplementedInWrapper;
use Wojciech\Phlambda\Internal\Classes\Placeholder;

/**
 * Returns currying function. Uses reflection to automatically detect number of parameters given callback is accepting.
 *
 * @param callable $callback callable accepting $n elements
 * @return callable
 * @throws \ReflectionException
 */
#[ShouldNotBeImplementedInWrapper]
function curry(callable $callback): callable
{
    if(is_array($callback)) {
        $reflector = new ReflectionMethod($callback[0], $callback[1]);
    } elseif(is_string($callback)) {
        $reflector = new ReflectionFunction($callback);
    } elseif(is_a($callback, 'Closure') || is_callable($callback)) {
        $objReflector = new ReflectionObject($callback);
        $reflector    = $objReflector->getMethod('__invoke');
    }

    return functionRequiringNParameters($reflector->getNumberOfRequiredParameters(), $callback);
}

#[ShouldNotBeImplementedInWrapper]
function functionRequiringNParameters(int $n, callable $fn, mixed ...$args): callable
{
    // This will return new function every time curry function is called without args
    return function (mixed ...$args2) use ($n, $fn, $args) {
        $arguments = [...$args, ...$args2];
        if (count($arguments) >= $n) return $fn(...$arguments);
        return functionRequiringNParameters($n, $fn, ...$arguments);
    };
}

/**
 * Returns currying function awaiting 3 arguments.
 *
 * @param callable $callback Callable accepting exactly 3 parameters.
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function curry3(callable $callback): callable
{
    return functionRequiringNParameters(3, $callback);
}

/**
 * Returns currying function awaiting 2 arguments.
 *
 * @param callable $callback Callable accepting exactly 2 parameters.
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function curry2(callable $callback): callable
{
    return functionRequiringNParameters(2, $callback);
}

/**
 * Returns currying function awaiting 1 argument.
 *
 * @param callable $callback Callable accepting exactly 1 parameter.
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function curry1(callable $callback): callable
{
    return functionRequiringNParameters(1, $callback);
}

/**
 * Returns placeholder for omitting some arguments in currying functions.
 */
#[ShouldNotBeImplementedInWrapper]
function __(): Placeholder
{
    return Placeholder::create();
}