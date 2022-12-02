<?php
declare(strict_types=1);

namespace Phlambda;

use ReflectionFunction;
use ReflectionMethod;
use Phlambda\Internal\Attributes\ShouldNotBeImplementedInWrapper;
use Phlambda\Internal\Placeholder;

/**
 * Returns currying function. Uses reflection to automatically detect number of parameters given callback is accepting.
 *
 * @param callable $callback callable to be curried
 * @return callable
 * @throws \ReflectionException
 */
#[ShouldNotBeImplementedInWrapper]
function curry(callable $callback): callable
{
    if (\is_array($callback) && \count($callback) === 2) { // method reference like [$this, 'method']
        $reflector = new ReflectionMethod($callback[0], $callback[1]);
    } elseif (\is_string($callback) && \strpos($callback, '::', 1)) { // method reference like Class::Method
        $reflector = new ReflectionMethod($callback);
    } elseif (\is_object($callback) && \method_exists($callback, '__invoke')) {
        $reflector = new ReflectionMethod($callback, '__invoke');
    } else {
        $reflector = new ReflectionFunction($callback);
    }

    return match ($reflector->getNumberOfRequiredParameters()) {
        1 => curry1($callback),
        2 => curry2($callback),
        3 => curry3($callback),
        default => curryN($reflector->getNumberOfRequiredParameters(), $callback)
    };
}

/**
 * Returns currying function expecting n parameters. If you know that your function will need 1, 2 or 3 params
 * use curry1, curry2, curry3 function as they are twice faster.
 *
 * @var int $argumentsCount number of expected parameters
 * @var callable $callback function to be curried accepting n params
 * @see curry1()
 * @see curry2()
 * @see curry3()
 */
#[ShouldNotBeImplementedInWrapper]
function curryN(int $argumentsCount, callable $callback): callable
{
    $accumulator = function (mixed ...$arguments) use ($argumentsCount, $callback, &$accumulator) {
        return function (mixed ...$newArguments) use ($argumentsCount, $callback, $arguments, $accumulator) {
            if (empty($arguments)) {
                $arguments = $newArguments;
            } else {
                $placeholdersToSkipReplace = 0;
                foreach ($newArguments as $newArgument) {
                    $replaced = false;
                    if (Placeholder::isPlaceholder($newArgument)) {
                        $placeholdersToSkipReplace++;
                        continue;
                    };

                    foreach ($arguments as $idx => $argument) {
                        // Both are placeholders
                        if (!Placeholder::isPlaceholder($argument)) continue;
                        if ($placeholdersToSkipReplace-- > 0) continue;
                        $arguments[$idx] = $newArgument;
                        $replaced = true;
                        break;
                    }

                    // if new argument wasn't replacing any existing placeholder, and it's not placeholder itself add it to arguments
                    if (!$replaced) {
                        $arguments[] = $newArgument;
                    }
                }
            }

            // no placeholders, all actual arguments are given
            if (\count(Placeholder::filterPlaceholders($arguments)) >= $argumentsCount) {
                return \call_user_func_array($callback, $arguments);
            }

            return $accumulator(...$arguments);
        };
    };

    return $accumulator();
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
    return $fn2 = function (...$v) use ($callback, &$fn2) {
        return match (\count($v)) {
            0 => $fn2,
            1 => Placeholder::isPlaceholder($v[0]) ? $fn2 : curry2(fn($_v1, $_v2) => call_user_func_array($callback, [...$v, $_v1, $_v2])),
            2 => Placeholder::isPlaceholder($v[0]) && Placeholder::isPlaceholder($v[1])
                ? $fn2
                : (
                    Placeholder::isPlaceholder($v[0])
                    ? curry2(fn($_v1, $_v2) => call_user_func_array($callback, [$_v1, $v[1], $_v2]))
                    : curry1(fn($_v1) => call_user_func_array($callback, [$v[0], $v[1], $_v1]))
                ),
            3 => Placeholder::isPlaceholder($v[0]) && Placeholder::isPlaceholder($v[1]) && Placeholder::isPlaceholder($v[2])
                ? $fn2
                : (
                    Placeholder::isPlaceholder($v[0]) && Placeholder::isPlaceholder($v[1])
                    ? curry2(fn($_v1, $_v2) => call_user_func_array($callback, [$_v1, $_v2, $v[2]]))
                    : (
                        Placeholder::isPlaceholder($v[0]) && Placeholder::isPlaceholder($v[2])
                        ? curry2(fn($_v1, $_v2) => call_user_func_array($callback, [$_v1, $v[1], $_v2]))
                        : (
                            Placeholder::isPlaceholder($v[1]) && Placeholder::isPlaceholder($v[2])
                            ? curry2(fn($_v1, $_v2) => call_user_func_array($callback, [$v[0], $_v1, $_v2]))
                            : (
                                Placeholder::isPlaceholder($v[0])
                                ? curry1(fn($_v1) => call_user_func_array($callback, [$_v1, $v[1], $v[2]]))
                                : (
                                    Placeholder::isPlaceholder($v[1])
                                    ? curry1(fn($_v1) => call_user_func_array($callback, [$v[0], $_v1, $v[2]]))
                                    : (
                                        Placeholder::isPlaceholder($v[2])
                                        ? curry1(fn($_v1) => call_user_func_array($callback, [$v[0], $v[1], $_v1]))
                                        : call_user_func_array($callback, $v)
                                    )
                                )
                            )
                        )
                    )
                )
        };
    };
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
    return $fn2 = function (...$v) use ($callback, &$fn2) {
        return match (\count($v)) {
            0 => $fn2,
            1 => Placeholder::isPlaceholder($v[0]) ? $fn2 : curry1(fn($_v) => call_user_func_array($callback, [...$v, $_v])),
            2 => Placeholder::isPlaceholder($v[0]) && Placeholder::isPlaceholder($v[1])
                ? $fn2
                : (
                    Placeholder::isPlaceholder($v[0])
                    ? curry1(fn ($_v1) => call_user_func_array($callback, [$_v1, $v[1]]))
                    : (
                        Placeholder::isPlaceholder($v[1])
                            ? curry1(fn ($_v1) => call_user_func_array($callback, [$v[0], $_v1]))
                            : call_user_func_array($callback, $v)
                    )
                )
        };
    };
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
    return $fn2 = function (...$v) use ($callback, &$fn2) {
        if (empty($v) || Placeholder::isPlaceholder($v[0])) {
            return $fn2;
        } else {
            return call_user_func_array($callback, $v);
        }
    };
}

/**
 * Returns placeholder for omitting some arguments in currying functions.
 */
#[ShouldNotBeImplementedInWrapper]
function __(): Placeholder
{
    return Placeholder::create();
}
