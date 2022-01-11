<?php /** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\ShouldNotBeImplementedInWrapper;

/**
 * Converts value to string.
 *
 * <blockquote><pre>toString(1) // it will return '1'</pre></blockquote>
 * <blockquote><pre>toString(true) // it will return '1'</pre></blockquote>
 * <blockquote><pre>toString(null) // it will return ''</pre></blockquote>
 *
 * @param mixed $item Element we wish to convert.
 * @return string|callable If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
#[ShouldNotBeImplementedInWrapper]
function toString(mixed...$v): string|callable
{
    return curry(fn (mixed $item) => (string) $item)(...$v);
}

const toString = '\Wojciech\Phlambda\toString';

/**
 * Returns true if given `$item` starts with `$expected` value.
 *
 * <blockquote><pre>startsWith('Lorem ipsum', 'Lorem ipsum 123') // it will return true</pre></blockquote>
 * <blockquote><pre>startsWith(' Lorem ipsum', 'Lorem ipsum 123') // it will return false</pre></blockquote>
 * <blockquote><pre>startsWith('lorem ipsum', 'Lorem ipsum 123') // it will return false</pre></blockquote>
 *
 * @param string $expected Expected start of the string.
 * @param string $item String we want to check.
 * @return bool|callable If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
#[ShouldNotBeImplementedInWrapper]
function startsWith(mixed...$v): bool|callable
{
    return curry2(fn (string $expected, string $item) => str_starts_with($item, $expected))(...$v);
}

const startsWith = '\Wojciech\Phlambda\startsWith';

/**
 * Test regular expression against a sting. Returns all matching elements or empty array if there aren't any.
 *
 * <blockquote><pre>matches('/([a-z]a)/', 'bananas') // it will return ['ba', 'na', 'na']</pre></blockquote>
 * <blockquote><pre>matches('/a/', 'b') // it will return []</pre></blockquote>
 *
 * @param string $expression Regexp.
 * @param string $item String we want to check.
 * @return bool|callable If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
#[ShouldNotBeImplementedInWrapper]
function matches(string...$v): array|callable
{
    return curry2(function (string $expression, string $item): array {
        preg_match_all($expression, $item, $matches, PREG_UNMATCHED_AS_NULL);
        return $matches[0] ?? [];
    })(...$v);
}

const matches = '\Wojciech\Phlambda\matches';