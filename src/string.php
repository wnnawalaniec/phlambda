<?php /** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace Wojciech\Phlambda;

/**
 * Converts value to string.
 *
 * @param mixed $item Element we wish to convert
 * @return string|callable If all arguments are given result is returned. Passing just some or none will result in currying function return.
 */
function toString(mixed...$v): string|callable
{
    return curring(fn (mixed $item) => (string) $item)(...$v);
}