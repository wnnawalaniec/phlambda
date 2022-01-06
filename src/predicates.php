<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

function below(float|int $a): callable
{
    return fn ($arg) => $arg < $a;
}

function above(float|int $a): callable
{
    return fn ($arg) => $arg > $a;
}