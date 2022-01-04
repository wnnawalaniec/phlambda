<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Classes\ArrayWrapper;

/**
 * Wraps array with ArrayWrapper object, so we can use nice for eye syntax.
 *
 * @param array $arr
 * @return ArrayWrapper
 */
function arr(array $arr): ArrayWrapper
{
    return ArrayWrapper::wrap($arr);
}

/**
 * @param array $arr
 * @param callable(mixed):array $predicate
 * @return array Array filtered by predicate. Keys will be preserved.
 */
function all(array $arr, callable $predicate): array
{
    return array_filter($arr, $predicate);
}

/**
 * @param array $arr
 * @param callable(mixed):array $function
 * @return array Array of elements from $arr mapped by function
 */
function map(array $arr, callable $function): array
{
    return array_map($function, $arr);
}
