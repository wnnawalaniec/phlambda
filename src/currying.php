<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

function curring3(callable $fn): callable
{
    return $fn2 = function (...$v) use ($fn, &$fn2) {
        return match (func_num_args()) {
            0 => $fn2,
            1 => curring2(fn (...$_v) => $fn(...$v, ...$_v)),
            2 => curring(fn (...$_v) => $fn(...$v, ...$_v)),
            3 => $fn(...$v),
        };
    };
}

function curring2(callable $fn): callable
{
    return $fn2 = function (...$v) use ($fn, &$fn2) {
          return match (func_num_args()) {
              0 => $fn2,
              1 => curring(fn (...$_v) => $fn(...$v, ...$_v)),
              2 => $fn(...$v)
          };
    };
}

function curring(callable $fn): callable
{
    return $fn2 = function (...$v) use ($fn, &$fn2) {
        return match (func_num_args()) {
            0 => $fn2,
            1 => $fn(...$v)
        };
    };
}