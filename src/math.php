<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use JetBrains\PhpStorm\Pure;

#[Pure] function add(float $num1, float $num2): float
{
    return $num1 + $num2;
}

#[Pure] function dec(float|int $num): float
{
    return add($num, -1);
}

#[Pure] function inc(float|int $num): float
{
    return add($num, 1);
}

#[Pure] function divide(float|int $num1, float|int $num2): float
{
    return $num1/$num2;
}

#[Pure] function multiply(float|int $num1, float|int $num2): float
{
    return $num1*$num2;
}

function sum(array $arr): float
{
    return array_reduce($arr, 'Wojciech\Phlambda\add', 0.0);
}