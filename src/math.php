<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\ShouldNotBeImplementedInWrapper;

#[ShouldNotBeImplementedInWrapper]
function add(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a + $b)(...$v);
}

const add = '\Wojciech\Phlambda\add';

#[ShouldNotBeImplementedInWrapper]
function subtract(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a - $b)(...$v);
}

const subtract = '\Wojciech\Phlambda\subtract';

#[ShouldNotBeImplementedInWrapper]
function dec(mixed ...$v): callable|float|int
{
    return add(-1)(...$v);
}

const dec = '\Wojciech\Phlambda\dec';

#[ShouldNotBeImplementedInWrapper]
function inc(mixed ...$v): callable|float|int
{
    return add(1)(...$v);
}

const inc = '\Wojciech\Phlambda\inc';

#[ShouldNotBeImplementedInWrapper]
function divide(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a/$b)(...$v);
}

const divide = '\Wojciech\Phlambda\divide';

#[ShouldNotBeImplementedInWrapper]
function multiply(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a*$b)(...$v);
}

const multiply = '\Wojciech\Phlambda\multiply';

#[ShouldNotBeImplementedInWrapper]
function sum(mixed ...$v): callable|float|int
{
    return reduce(add(), 0.0)(...$v);
}

const sum = '\Wojciech\Phlambda\sum';