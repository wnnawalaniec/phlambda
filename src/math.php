<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

function add(mixed ...$v): callable|float
{
    return curring2(fn (int|float $a, int|float $b) => $a + $b)(...$v);
}

function subtract(mixed ...$v): callable|float
{
    return curring2(fn (int|float $a, int|float $b) => $a - $b)(...$v);
}

function dec(mixed ...$v): callable|float
{
    return add(-1)(...$v);
}

function inc(mixed ...$v): callable|float
{
    return add(1)(...$v);
}

function divide(mixed ...$v): callable|float
{
    return curring2(fn (int|float $a, int|float $b) => $a/$b)(...$v);
}

function multiply(mixed ...$v): callable|float
{
    return curring2(fn (int|float $a, int|float $b) => $a*$b)(...$v);
}

function sum(mixed ...$v): callable|float
{
    return reduce(add(), 0.0)(...$v);
}