<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\ShouldNotBeImplementedInWrapper;

#[ShouldNotBeImplementedInWrapper]
function below(float|int $a): callable
{
    return fn ($arg) => $arg < $a;
}

#[ShouldNotBeImplementedInWrapper]
function above(float|int $a): callable
{
    return fn ($arg) => $arg > $a;
}