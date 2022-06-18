<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\Attributes\ShouldNotBeImplementedInWrapper;

/**
 * Returns function checking if given value is below expected.
 */
#[ShouldNotBeImplementedInWrapper]
function below(float|int $expected): callable
{
    return fn ($arg) => $arg < $expected;
}

/**
 * Returns function checking if given value is above expected.
 */
#[ShouldNotBeImplementedInWrapper]
function above(float|int $expected): callable
{
    return fn ($arg) => $arg > $expected;
}

/**
 * Returns function that check if value is instance of given type.
 * To check generic types pass:
 *  - `int`
 *  - `float`
 *  - `bool`
 *  - `string`
 *  - `array`
 *  - `object`
 */
#[ShouldNotBeImplementedInWrapper]
function ofType(string $type): callable
{
    return match ($type){
        'int' => fn ($arg) => is_int($arg),
        'float' => fn ($arg) => is_float($arg),
        'bool' => fn ($arg) => is_bool($arg),
        'array' => fn ($arg) => is_array($arg),
        'string' => fn ($arg) => is_string($arg),
        'object' => fn ($arg) => is_object($arg),
        default => fn ($arg) => $arg instanceof $type
    };
}