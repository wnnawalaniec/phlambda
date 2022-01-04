<?php
declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

#[Pure] function add(float|null $a, float|null $b): float
{
    return $a + $b;
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
    return array_reduce($arr, 'add', 0.0);
}