<?php /** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\ShouldNotBeImplementedInWrapper;

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
 * @param callable(mixed): bool $fn1
 * @param callable(mixed): bool $fn2
 * @return callable
 */
#[ShouldNotBeImplementedInWrapper]
function both(callable...$v): callable
{
    return curry2(fn (callable $fn1, callable $fn2): callable => fn (mixed $x) => $fn1($x) && $fn2($x))(...$v);
}

const both = '\Wojciech\Phlambda\both';