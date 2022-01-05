<?php /** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internals as internals;

/**
 * Returns true if all elements from the array match the predicate, false if
 * there is any which doesn't.
 *
 * It checks all the array elements with given predicate and returns true if all matches.
 * False is returned when at least one is not matching.
 *
 * Basic usage may look like this:
 * <blockquote><pre>all(below(4), [1,2,3]); // it will return true</pre></blockquote>
 *
 * You can also use it that way:
 * <blockquote><pre>
 * $below18 = all(below(18)); // it will return curring function
 * if ($below18($someUsers)) { // you can use that in code like normal function
 *  ...
 * };
 * </pre></blockquote>
 *
 * @param callable(mixed): bool $fn First param must be callable accepting one element and returning true or false.
 * @param array $array Second param must be array which we want to check.
 * @return callable|bool If both params will be passed bool result is returned. Passing none or only first will result in returning a currying function.
 */
function all(...$v): callable|bool
{
    return internals\curring2(fn (callable $fn, array $arr) => count(array_filter($arr, $fn)) === count($arr))(...$v);
}

/**
 * Reduces array to single value using provided callback.
 *
 * This function iterates through whole array accumulating its values together using
 * given callback. It also requires initial value but this can be set to null, but keep
 * in mind that if you will use null as initial value and pass empty array, exception will
 * be thrown.
 *
 * Example use:
 * <blockquote><pre>reduce(concat(), '1', ['2', '3', '4'])  // Returns '1234'</pre></blockquote>
 * <blockquote><pre>reduce(concat(), null, ['2', '3', '4'])  // Returns '234'</pre></blockquote>
 * <blockquote><pre>reduce(concat(), '')  // Returns curring function accepting array as param</pre></blockquote>
 *
 * @param callable(mixed): bool $fn Function must accept one param and return bool.
 * @param array $arr The input array
 * @return mixed Returned type will be same as <var>$fn</var> callback.
 * @throws \InvalidArgumentException When array is empty and null initial value was passed.
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
 * Concat two elements arrays or strings.
 *
 * This function concat given parameters and return single value.
 * Returned value is of same type as passed arguments. If two strings
 * are passed, string is returned. Same if you use arrays.
 *
 * Example use:
 * <blockquote><pre>concat('12', '34')  // Returns '1234'</pre></blockquote>
 * <blockquote><pre>concat([1], [2])  // Returns [1,2]</pre></blockquote>
 * <blockquote><pre>concat([], [])  // Returns []</pre></blockquote>
 *
 * Note: for array concat array_merge is used so if you want to know how
 * keys will behave see it's documentation.
 *
 * @see \array_merge()
 * @param string|array $a First element to concat
 * @param string|array $b Second element to concat
 * @return string|array Returned type will be same as passed parameters.
 * @throws \InvalidArgumentException When both parameters are not of same type
 */
function concat(...$v): callable|string|array
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