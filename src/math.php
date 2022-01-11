<?php /** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\ShouldNotBeImplementedInWrapper;

/**
 * Returns sum of two numbers.
 *
 * Returns float if at least one number is float.
 *
 * @param int|float $a
 * @param int|float $b
 * @return callable|float|int If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
#[ShouldNotBeImplementedInWrapper]
function add(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a + $b)(...$v);
}

const add = '\Wojciech\Phlambda\add';

/**
 * Returns subtraction of two numbers.
 *
 * Returns float if at least one number is float.
 *
 * @param int|float $a
 * @param int|float $b
 * @return callable|float|int If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
#[ShouldNotBeImplementedInWrapper]
function subtract(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a - $b)(...$v);
}

const subtract = '\Wojciech\Phlambda\subtract';

/**
 * Decreases number by 1.
 *
 * Return type is same as given number.
 *
 * @param int|float $a
 * @return callable|float|int If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
#[ShouldNotBeImplementedInWrapper]
function dec(mixed ...$v): callable|float|int
{
    return add(-1)(...$v);
}

const dec = '\Wojciech\Phlambda\dec';

/**
 * Increases number by 1.
 *
 * Return type is same as given number.
 *
 * @param int|float $a
 * @param int|float $b
 * @return callable|float|int If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
#[ShouldNotBeImplementedInWrapper]
function inc(mixed ...$v): callable|float|int
{
    return add(1)(...$v);
}

const inc = '\Wojciech\Phlambda\inc';

/**
 * Divides two numbers.
 *
 * Returns float if at least one number is float.
 *
 * @param int|float $a
 * @param int|float $b
 * @return callable|float|int If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
#[ShouldNotBeImplementedInWrapper]
function divide(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a/$b)(...$v);
}

const divide = '\Wojciech\Phlambda\divide';

/**
 * Multiplies two numbers.
 *
 * Returns float if at least one number is float.
 *
 * @param int|float $a
 * @param int|float $b
 * @return callable|float|int If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
#[ShouldNotBeImplementedInWrapper]
function multiply(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a*$b)(...$v);
}

const multiply = '\Wojciech\Phlambda\multiply';

/**
 * Returns sum of all elements.
 *
 * Returns float if at least one number is float.
 *
 * @param int|float $a
 * @param int|float $b
 * @return callable|float|int If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
#[ShouldNotBeImplementedInWrapper]
function sum(mixed ...$v): callable|float|int
{
    return reduce(add(), 0.0)(...$v);
}

const sum = '\Wojciech\Phlambda\sum';