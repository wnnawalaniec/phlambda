<?php /** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internals as internals;

/**
 * On each element <var>$fn</var> predicate is performed and returns all for which true was returned.
 *
 * @param callable(mixed, mixed): mixed $fn <p>
 * The callback function. Signature is <pre>callback ( mixed $carry , mixed $item ) : mixed</pre>
 * <blockquote>mixed <var>$carry</var> <p>The return value of the previous iteration; on the first iteration it holds the value of <var>$initialValue</var>.</p></blockquote>
 * <blockquote>mixed <var>$item</var> <p>Holds the current iteration value of the <var>$arr</var></p></blockquote>
 * </p>
 * @param mixed|null $initialValue If the value is provided it will be used with first iteration, otherwise null will be used
 * @param array $arr The input array
 * @return mixed Returned type will be same as <var>$fn</var> callback.
 *
 * <p>
 * If the array is empty and initial is not passed exception will be thrown.
 * </p>
 * <br/>
 * <p>
 * Example use:
 * <blockquote><pre>reduce(concat(), '1', ['2', '3', '4'])  // Returns '1234'</pre></blockquote>
 * <blockquote><pre>reduce(concat(), null, ['2', '3', '4'])  // Returns '234'</pre></blockquote>
 * <blockquote><pre>reduce(concat(), '')  // Returns curring function accepting array as param</pre></blockquote>
 * <br/>
 * </p>
 */
function all(...$v): mixed
{
    return internals\curring2(fn (callable $fn, array $arr) => array_filter($arr, $fn))(...$v);
}

/**
 * Reduces array to single value using provided callback.
 *
 * @throws \InvalidArgumentException When <var>$arr</var> is empty and <var>$initialValue</var> is null
 * @param callable(mixed): bool $fn <p>
 * The callback function. Signature is <pre>callback ( mixed $item ) : bool</pre>
 * <blockquote>mixed <var>$item</var> <p>Holds the current iteration value of the <var>$arr</var></p></blockquote>
 * </p>
 * @param array $arr The input array
 * @return array Returned type will be same as <var>$fn</var> callback.
 *
 * <p>
 * If the array is empty and initial is not passed exception will be thrown.
 * </p>
 * <br/>
 * <p>
 * Example use:
 * <blockquote><pre>reduce(concat(), '1', ['2', '3', '4'])  // Returns '1234'</pre></blockquote>
 * <blockquote><pre>reduce(concat(), null, ['2', '3', '4'])  // Returns '234'</pre></blockquote>
 * <blockquote><pre>reduce(concat(), '')  // Returns curring function accepting array as param</pre></blockquote>
 * <br/>
 * </p>
 */
function reduce(...$v): mixed
{
    return internals\curring3(function (callable $fn, mixed $initialValue, array $arr) {
        if (empty($arr) && is_null($initialValue)) {
            throw new \InvalidArgumentException('Empty array and no initial value given');
        }

        if ($initialValue) {
            return array_reduce($arr, $fn, $initialValue);
        }

        $initialValue = array_shift($arr);
        return array_reduce($arr, $fn, $initialValue);
    })(...$v);
}

/**
 * Concat two elements (arrays or strings) into single one.
 *
 * @throws \InvalidArgumentException When <var>$a</var> and <var>$b</var> are not both arrays or string
 * @param string|array $a First element to concat
 * @param string|array $b Second element to concat
 * @return string|array Returned type will be same as passed parameters.
 *
 * <p>
 * If both parameters are of different type exception is thrown.
 * </p>
 * <br/>
 * <p>
 * Example use:
 * <blockquote><pre>concat('12', '34')  // Returns '1234'</pre></blockquote>
 * <blockquote><pre>concat([1], [2])  // Returns [1,2]</pre></blockquote>
 * <blockquote><pre>concat([], [])  // Returns []</pre></blockquote>
 * <br/>
 * </p>
 */
function concat(...$v): mixed
{
    return internals\curring2(function ($a, $b) {
        if (is_array($a) && is_array($b)) {
            return array_merge($a, $b);
        }

        if (is_string($a) && is_string($b)) {
            return $a . $b;
        }

        throw new \InvalidArgumentException('Both parameters must be string or array');
    })(...$v);
}