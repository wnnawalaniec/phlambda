<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\ShouldNotBeImplementedInWrapper;

#[ShouldNotBeImplementedInWrapper]
function below(float|int $a): callable
{
    return fn ($arg) => $arg < $a;
}

const below = '\Wojciech\Phlambda\below';

#[ShouldNotBeImplementedInWrapper]
function above(float|int $a): callable
{
    return fn ($arg) => $arg > $a;
}

const above = '\Wojciech\Phlambda\above';