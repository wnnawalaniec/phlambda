<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

function add(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a + $b)(...$v);
}

const add = '\Wojciech\Phlambda\add';

function subtract(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a - $b)(...$v);
}

const subtract = '\Wojciech\Phlambda\subtract';

function dec(mixed ...$v): callable|float|int
{
    return add(-1)(...$v);
}

const dec = '\Wojciech\Phlambda\dec';

function inc(mixed ...$v): callable|float|int
{
    return add(1)(...$v);
}

const inc = '\Wojciech\Phlambda\inc';

function divide(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a/$b)(...$v);
}

const divide = '\Wojciech\Phlambda\divide';

function multiply(mixed ...$v): callable|float|int
{
    return curry2(fn (int|float $a, int|float $b) => $a*$b)(...$v);
}

const multiply = '\Wojciech\Phlambda\multiply';

function sum(mixed ...$v): callable|float|int
{
    return reduce(add(), 0.0)(...$v);
}

const sum = '\Wojciech\Phlambda\sum';