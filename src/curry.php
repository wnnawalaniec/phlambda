<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use ReflectionFunction;
use ReflectionMethod;
use Wojciech\Phlambda\Internal\Attributes\ShouldNotBeImplementedInWrapper;
use Wojciech\Phlambda\Internal\Classes\Placeholder;

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

    return curryN($reflector->getNumberOfRequiredParameters(), $callback);
}

/**
 * Returns currying function expecting n parameters.
 *
 * @var int $argumentsCount number of expected parameters
 * @var callable $callback function to be curried accepting n params
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
                    foreach ($arguments as $idx => $argument) {
                        // Both are placeholders
                        if (Placeholder::isPlaceholder($argument) && Placeholder::isPlaceholder($newArgument)) {
                            $placeholdersToSkipReplace++;
                            break;
                        }
                        // If any argument is placeholder and new one is not, replace it
                        if (Placeholder::isPlaceholder($argument) && !Placeholder::isPlaceholder($newArgument)) {
                            if ($placeholdersToSkipReplace > 0) continue;
                            $arguments[$idx] = $newArgument;
                            $replaced = true;
                            break;
                        }
                    }

                    // if new argument wasn't replacing any existing placeholder, and it's not placeholder itself add it to arguments
                    if (!$replaced && !Placeholder::isPlaceholder($newArgument)) {
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
    return curryN(3, $callback);
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
    return curryN(2, $callback);
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
    return curryN(1, $callback);
}

/**
 * Returns placeholder for omitting some arguments in currying functions.
 */
#[ShouldNotBeImplementedInWrapper]
function __(): Placeholder
{
    return Placeholder::create();
}