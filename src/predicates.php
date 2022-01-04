<?php
declare(strict_types=1);

function below(float|int $a): callable
{
    return fn ($arg) => $arg < $a;
}