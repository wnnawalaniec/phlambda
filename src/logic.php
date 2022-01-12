<?php /** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\ShouldNotBeImplementedInWrapper;

/**
 * Function returns `true` if both arguments are `true`;
 *
 * Example:
 * <blockquote><pre>_and(true, true); // it will return true</pre></blockquote>
 *
 * @see both()
 * @param bool $input1
 * @param bool $input2
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function _and(bool...$v): bool|callable
{
    return curry2(fn (bool $input1, bool $input2) => $input1 && $input2)(...$v);
}

/**
 * Function calling two provided functions and returning the `&&` of the results.
 *
 * This functions accepts two predicates and then return function accepting one parameter and calling both predicates
 * with that parameter. Then `&&` of both results is returned.
 * Keep in mind that if first function will return `false` second one won't be call.
 *
 * Example:
 * <blockquote><pre>both('is_number', below(3))(1) // it will return true</pre></blockquote>
 * <blockquote><pre>filter(both(above(18), below(30), [11, 19, 26, 40]); // it will return [19, 26]</pre></blockquote>
 *
 * @see _and()
 * @param callable(mixed): bool $fn1
 * @param callable(mixed): bool $fn2
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function both(callable...$v): callable
{
    return curry2(fn (callable $fn1, callable $fn2): callable => fn (mixed $x) => $fn1($x) && $fn2($x))(...$v);
}

/**
 * Function calling two provided functions and returning the `||` of the results.
 *
 * This functions accepts two predicates and then return function accepting one parameter and calling both predicates
 * with that parameter. Then `||` of both results is returned.
 * Keep in mind that both given functions will be called.
 *
 * Example:
 * <blockquote><pre>either(above(5), below(3))(1) // it will return true</pre></blockquote>
 * <blockquote><pre>filter(either(above(18), below(30), [11, 19, 26, 40]); // it will return [11, 19, 26, 40]</pre></blockquote>
 *
 * @see _or(), neither()
 * @param callable(mixed): bool $fn1
 * @param callable(mixed): bool $fn2
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function either(callable...$v): callable
{
    return curry2(fn (callable $fn1, callable $fn2): callable => fn (mixed $x) => $fn1($x) || $fn2($x))(...$v);
}

/**
 * Function returns inverted result of the input.
 *
 * Example:
 * <blockquote><pre>not(true); // it will return false</pre></blockquote>
 * <blockquote><pre>not(false); // it will return true</pre></blockquote>
 *
 * @param bool $input
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function not(bool...$v): bool|callable
{
    return curry(fn (bool $input) => !$input)(...$v);
}

/**
 * Function calling two provided functions and returning true when both are returning false.
 *
 * This functions accepts two predicates and then return function accepting one parameter and calling both predicates
 * with that parameter. Then negation of `&&` operation on both results is returned.
 * Keep in mind that if first function will return `false` second one won't be call.
 *
 * Example:
 * <blockquote><pre>neither(above(5), below(3))(4) // it will return true</pre></blockquote>
 * <blockquote><pre>neither(above(1), below(3))(4) // it will return false</pre></blockquote>
 *
 * @see either(), not()
 * @param callable(mixed): bool $fn1
 * @param callable(mixed): bool $fn2
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function neither(callable...$v): callable
{
    return curry2(fn (callable $fn1, callable $fn2): callable => fn (mixed $x) => not(either($fn1, $fn2)($x)))(...$v);
}

/**
 * Function returns `true` if at least one arguments is `true`;
 *
 * Example:
 * <blockquote><pre>_or(false, true); // it will return true</pre></blockquote>
 * <blockquote><pre>_or(false, false); // it will return false</pre></blockquote>
 *
 * @see either()
 * @param bool $input1
 * @param bool $input2
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function _or(bool...$v): bool|callable
{
    return curry2(fn (bool $input1, bool $input2) => $input1 || $input2)(...$v);
}
