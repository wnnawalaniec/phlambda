<?php /** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\ShouldNotBeImplementedInWrapper;

/**
 * Return copy of an array with replaced element at given index.
 *
 * Applies a function to the value at given index, returning new copy of the input array with the element at given
 * index replaced with the result of the function. Index is 0 based, and negative numbers can be used to point element
 * from the end of the array (-1 is last element, -2 is one before last and so on).
 * If index is greater than the size of array unchanged copy is returned.
 *
 * Basic usage may look like this:
 * <blockquote><pre>adjust(inc(), 2, [1, 2, 3]); // it will return [1, 2, 4]</pre></blockquote>
 * <blockquote><pre>adjust(inc(), -1, [1, 2, 3]); // it will return [1, 2, 4]</pre></blockquote>
 *
 * @param callable(mixed): mixed $fn First param must be callable accepting one argument and returning some value.
 * @param int $idx Second param must index of the element in the array, which should be replaced with given function.
 * @param array $input Last param must be array which we wish to adjust.
 * @return callable|array If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
function adjust(int|callable|array...$v): array|callable
{
    return curry3(function (callable $fn, int $idx, array $input): array {
        if ($idx < 0) {
            $idx = count($input) + $idx;
        }

        if (!isset($input[$idx])) {
            return $input;
        }

        $input[$idx] = $fn($input[$idx]);
        return $input;
    })(...$v);
}

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
 * @see any()
 * @param callable(mixed): bool $fn First param must be callable accepting one element and returning true or false.
 * @param array $array Second param must be array which we want to check.
 * @return callable|bool If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
function all(...$v): callable|bool
{
    return curry2(fn (callable $fn, array $input) => count(array_filter($input, $fn)) === count($input))(...$v);
}

/**
 * Return true if any element matches given predicate.
 *
 * It checks all the array elements with given predicate and returns true if any matches.
 *
 * Basic usage may look like this:
 * <blockquote><pre>any(above(1), [1, 2, 3]); // it will return true</pre></blockquote>
 * <blockquote><pre>any(below(0), [1, 2, 3]); // it will return false</pre></blockquote>
 *
 * @see all()
 * @param callable(mixed): bool $fn First param must be callable accepting one argument and returning true or false.
 * @param array $input Second param must be array which we wish to adjust.
 * @return callable|array If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
function any(...$v): callable|bool
{
    return curry2(fn (callable $fn, array $input) => !empty(array_filter($input, $fn)))(...$v);
}

/**
 * Return copy of an array with given element appended at the end.
 *
 * Appends element to the end of the given array and returns new array.
 *
 * Basic usage may look like this:
 * <blockquote><pre>append(4, [1, 2, 3]); // it will return [1, 2, 3, 4]</pre></blockquote>
 * <blockquote><pre>append([4], [1, 2, 3]); // it will return [1, 2, 3, [4]]</pre></blockquote>
 *
 * @see concat()
 * @param mixed $item First param is a value to append.
 * @param array $input Second param is an array to be appended.
 * @return callable|array If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
function append(...$v): callable|array
{
    return curry2(function (mixed $item, array $input) { $input[] = $item; return $input; })(...$v);
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
 * @see append()
 * @param string|array $a First element to concat
 * @param string|array $b Second element to concat
 * @return string|array|callable If all arguments are given result is returned. Returned type will be same as passed parameters. Passing just some or none will result in curry function return.
 * @throws \InvalidArgumentException When both parameters are not of same type
 */
function concat(string|array...$v): callable|string|array
{
    return curry2(function ($a, $b) {
        if (is_array($a) && is_array($b)) {
            return array_merge($a, $b);
        }

        if (is_string($a) && is_string($b)) {
            return $a . $b;
        }

        throw new \InvalidArgumentException('Both parameters must be string or array');
    })(...$v);
}

/**
 * Applies given function to each element of the array and return new one with the results.
 *
 * It works like `array_map`. Exactly like this.
 *
 * Basic usage may look like this:
 * <blockquote><pre>map(toString(), [1, 2, 3]); // it will return ['1', '2', '3']</pre></blockquote>
 *
 * @see flatMap()
 * @param callable(mixed): mixed $fn Function must accept one param and return some value.
 * @param array $input Array we want to map.
 * @return callable|array If all arguments are given result is returned. Passing just some or none will result in curry function return.
 * Type of array will be same as type of returned values from given callback.
 */
function diff(array...$v): callable|array
{
    return curry2(fn (array $input1, array $input2) => array_diff($input1, $input2))(...$v);
}

/**
 * Return copy of an array/string but without first `n` elements of the given `input`.
 *
 * Number of the elements can exceed size of the given array/string, in that case empty array/string will be returned.
 * If negative number will be given, unchanged array/string is returned.
 * For strings, `mbstring` functions are used.
 *
 * Basic usage may look like this:
 * <blockquote><pre>drop(1, [1, 2, 3]); // it will return [2, 3]</pre></blockquote>
 * <blockquote><pre>drop(3, [1, 2, 3]); // it will return []</pre></blockquote>
 * <blockquote><pre>drop(2, '123'); // it will return '3'</pre></blockquote>
 *
 * @see dropLast()
 * @param int $n First param must number of the elements to be dropped.
 * @param array|string $input Next param must be array|string we wish to consider.
 * @return callable|array|string If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
function drop(int|string|array...$v): callable|string|array
{
    return curry2(function (int $n, string|array $input){
        if ($n < 0) {
            return $input;
        }

        if (is_string($input)) {
            return mb_substr($input, $n, null, mb_detect_encoding($input));
        }

        return array_slice($input, $n);
    })(...$v);
}

/**
 * Return copy of an array or string but without `n` last elements of the given `input`.
 *
 * Number of the elements can exceed size of the given array/string, in that case empty array/string will be returned.
 * If negative number will be given, unchanged array/string is returned.
 * For strings, `mbstring` functions are used.
 *
 * Basic usage may look like this:
 * <blockquote><pre>dropLast(1, [1, 2, 3]); // it will return [1, 2]</pre></blockquote>
 * <blockquote><pre>dropLast(2, '123'); // it will return '12'</pre></blockquote>
 * <blockquote><pre>dropLast(3, '123'); // it will return ''</pre></blockquote>
 *
 * @see drop()
 * @param int $n First param must number of the elements to be dropped.
 * @param array|string $input Next param must be array or string we wish to consider.
 * @return callable|array|string If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
function dropLast(int|string|array...$v): callable|string|array
{
    return curry2(function (int $n, string|array $input){
        if ($n < 0) {
            return $input;
        }

        if (is_string($input)) {
            return mb_substr($input, 0, -$n, mb_detect_encoding($input));
        }

        return array_slice($input, 0, -$n);
    })(...$v);
}

/**
 * Return copy of an array but without repeating elements.
 *
 * Keep in mind that your keys won't be preserved. Elements are considered as repeated when they are the same (`===`).
 * Note: `array_unique` is not used in that case as it's not strictly comparing elements - it seems 1 and '1' as same
 * values. The current implementation is foreach building new array and using `in_array` which maybe not the fastest
 * solution.
 *
 * Basic usage may look like this:
 * <blockquote><pre>dropRepeats([1, 1, '1', 2, 3]); // it will return [1, '1', 2, 3]</pre></blockquote>
 *
 * @param array $input Array we want to have with unique values only
 * @return callable|array If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
function dropRepeats(array...$v): callable|array
{
    return curry(function (array $input) {
        $result = [];
        foreach ($input as $value) {
            if (!in_array($value, $result, true)) {
                $result[] = $value;
            }
        }
        return $result;
    })(...$v);
}

/**
 * Iterates over each element of given array and returns only those who matches given predicate.
 *
 * Basic usage may look like this:
 * <blockquote><pre>filter(below(3), [1, 2, 3]); // it will return [1, 2]</pre></blockquote>
 *
 * @param callable(mixed): bool $fn First param must be callable accepting one element and returning true or false.
 * @param array $input Array we want to filter.
 * @return callable|array If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
function filter(array|callable...$v): callable|array
{
    return curry2(fn (callable $fn, array $input) => array_filter($input, $fn))(...$v);
}

/**
 * Works like map but result is single dimension array.
 *
 * It's like map but if callback returns array it is merged into result.
 *
 * Basic usage may look like this:
 * <blockquote><pre>
 * $duplicate = fn ($x) => [$x, $x];
 * flatMap($duplicate, [1, 2, 3]); // it will return [1, 1, 2, 2, 3, 3]
 * </pre></blockquote>
 *
 * @see map()
 * @see flat()
 * @param callable(mixed): mixed $fn Function must accept one param and return some value.
 * @param array $input Array we want to map.
 * @return callable|array If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
function flatMap(array|callable...$v): callable|array
{
    return curry2(function (callable $fn, array $input): array {
        return flat(true)(map($fn, $input));
    })(...$v);
}

/**
 * Makes single dimension array from mulit-dimension one.
 *
 * It makes multi-dimension array flatter. If first argument will be true, it will do this recursively.
 *
 * Basic usage may look like this:
 * <blockquote><pre>
 * flat(false, [[1], [2], [3]]); // it will return [1, 2, 3]
 * flat(true, [[1], [2], [3]]); // it will return [1, 2, 3]
 * flat(false, [[[1]], [[2]], [[3]]]); // it will return [[1], [2], [3]]
 * flat(true, [[[1]], [[2]], [[3]]]); // it will return [1, 2, 3]
 * </pre></blockquote>
 *
 * @see flatMap()
 * @param callable(mixed): mixed $fn Function must accept one param and return some value.
 * @param array $input Array we want to map.
 * @return callable|array If all arguments are given result is returned. Passing just some or none will result in curry function return.
 */
#[ShouldNotBeImplementedInWrapper]
function flat(mixed...$v): callable|array
{
    return curry2(function (bool $recursive, mixed $input): array {
        if (!is_array($input)) {
            return [$input];
        }

        $result = [];
        foreach ($input as $item) {
            $value = $recursive ? flat(true, $item) : $item;
            if (is_array($value)) {
                $result = concat($result, $value);
            } else {
                $result[] = $value;
            }
        }

        return $result;
    })(...$v);
}

/**
 * Applies given function to each element of the array and return new one with the results.
 *
 * It works like `array_map`. Exactly like this.
 *
 * Basic usage may look like this:
 * <blockquote><pre>map(toString(), [1, 2, 3]); // it will return ['1', '2', '3']</pre></blockquote>
 *
 * @see flatMap()
 * @param callable(mixed): mixed $fn Function must accept one param and return some value.
 * @param array $input Array we want to map.
 * @return callable|array If all arguments are given result is returned. Passing just some or none will result in curry function return.
 * Type of array will be same as type of returned values from given callback.
 */
function map(...$v): array|callable
{
    return curry2(fn (callable $fn, array $input) => array_map($fn, $input))(...$v);
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
 * @param array $input The input array
 * @return mixed If all arguments are given result is returned. Returned type will be same as <var>$fn</var> callback. Passing just some or none will result in curry function return.
 * @throws \InvalidArgumentException When array is empty and null initial value was passed.
 */
function reduce(...$v): mixed
{
    return curry3(function (callable $fn, mixed $initialValue, array $input): mixed {
        if (empty($input) && is_null($initialValue)) {
            throw new \InvalidArgumentException('Empty array and no initial value given');
        }

        if ($initialValue) {
            return array_reduce($input, $fn, $initialValue);
        }

        $initialValue = array_shift($input);
        return array_reduce($input, $fn, $initialValue);
    })(
        ...$v);
}

/**
 * Wraps array with Wrapper object.
 *
 * Example:
 * <blockquote><pre>
 * _([1,2,3,4,5])
 *   ->all(above(2))
 *   ->drop(1)
 *   ->reduce(add(), 0);
 * </blockquote></pre>
 *
 * @see Wrapper
 * @param array $array
 * @return Wrapper
 */
#[ShouldNotBeImplementedInWrapper]
function _(array $array): Wrapper
{
    return Wrapper::wrap($array);
}