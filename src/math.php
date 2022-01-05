<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use JetBrains\PhpStorm\Pure;
use Wojciech\Phlambda\Internals as internals;

#[Pure] function add(...$v): callable|float
{
    return internals\curring2(fn (int|float $a, int|float $b) => $a + $b)(...$v);
}

#[Pure] function dec(float|int|null $a): float
{
    return add($a, -1);
}

#[Pure] function inc(float|int|null $a): float
{
    return add($a, 1);
}

#[Pure] function divide(float|int|null $a, float|int|null $b): float
{
    return $a/$b;
}

#[Pure] function multiply(float|int|null $a, float|int|null $b): float
{
    return $a*$b;
}

function sum(array $arr): float
{
    return array_reduce($arr, 'Wojciech\Phlambda\add', 0.0);
}