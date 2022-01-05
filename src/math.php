<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use JetBrains\PhpStorm\Pure;
use Wojciech\Phlambda\Internals as internals;

#[Pure] function add(mixed ...$v): callable|float
{
    return internals\curring2(fn (int|float $a, int|float $b) => $a + $b)(...$v);
}

#[Pure] function subtract(mixed ...$v): callable|float
{
    return internals\curring2(fn (int|float $a, int|float $b) => $a - $b)(...$v);
}

#[Pure] function dec(mixed ...$v): callable|float
{
    return add(-1)(...$v);
}

#[Pure] function inc(mixed ...$v): callable|float
{
    return add(1)(...$v);
}

#[Pure] function divide(mixed ...$v): callable|float
{
    return internals\curring2(fn (int|float $a, int|float $b) => $a/$b)(...$v);
}

#[Pure] function multiply(mixed ...$v): callable|float
{
    return internals\curring2(fn (int|float $a, int|float $b) => $a*$b)(...$v);
}

function sum(mixed ...$v): callable|float
{
    return reduce(add(), 0.0)(...$v);
}