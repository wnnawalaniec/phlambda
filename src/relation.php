<?php /** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\Attributes\ShouldNotBeImplementedInWrapper;

/**
 * Restricts value to given minimum and maximum.
 *
 * Can be used with anything comparable like `int`, `string`, `\DateTime`, etc.
 *
 * Basic usage may look like this:
 * <blockquote><pre>clamp(1, 10, 0); // it will return 1</pre></blockquote>
 * <blockquote><pre>clamp(1, 10, 15); // it will return 10</pre></blockquote>
 * <blockquote><pre>clamp(1, 10, 6); // it will return 6</pre></blockquote>
 *
 * @param mixed $min Minimum value
 * @param mixed $max Maximum value
 * @param mixed $item Value to be clamped
 * @return callable|mixed If all arguments are given result is returned. Passing just some or none will result in currying function return.
 */
#[ShouldNotBeImplementedInWrapper]
function clamp(...$v): mixed
{
    return curry3(function (mixed $min, mixed $max, mixed $item): mixed {
        if ($max < $min) throw new \InvalidArgumentException('max must be greater than min');
        return $item < $min
            ? $min
            : min($item, $max);
    })(...$v);
}
