<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

/**
 * Creates predicate which accepts single numeric value and return true whenever that value is
 * less than expected one.
 *
 * @param float|int $num
 * @return callable(float|int): float|int
 */
function below(float|int $num): callable
{
    return fn ($arg) => $arg && $arg < $num;
}

/**
 * Creates predicate which accepts single numeric value and return true whenever that value is
 * greater than expected one.
 *
 * @param float|int $num
 * @return callable(float|int): float|int
 */
function above(float|int $num): callable
{
    return fn ($arg) => $arg > $num;
}