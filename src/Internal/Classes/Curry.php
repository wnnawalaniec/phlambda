<?php
declare(strict_types=1);

namespace Wojciech\Phlambda\Internal\Classes;

use Wojciech\Phlambda\Internal\Exceptions\TooMuchArgumentsGiven;

/**
 * Internal class that encapsulates curring functions generation.
 */
final class Curry
{
    public function __construct(private \Closure $callable, private int $numberOfExpectedArguments) {}

    /**
     * Depend on number of expected arguments given in constructor and number of arguments
     * given to this method, 3 things can happen:
     *  - when number of arguments equals expected number, given callable will be called with all arguments and result
     * will be returned.
     *  - when 0 arguments are passed, just instance of called object is returned
     *  - when less than expected number of arguments are given, another Curry object is created expecting rest of arguments
     *
     * @throws TooMuchArgumentsGiven when more than expected number of arguments are given
     */
    public function __invoke(...$v)
    {
        if ($this->noArgumentsAreGiven($v)) {
            return $this;
        }

        if ($this->isMoreThenExpectedArgumentsGiven($v)) {
            throw TooMuchArgumentsGiven::create($this->numberOfExpectedArguments);
        }

        $closure = $this->callable;
        if ($this->isExpectedNumberOfArgumentsGiven($v)) {
            return $closure(...$v);
        }

        $partiallyCompleteCallable = fn(...$_v) => $closure(...$v, ...$_v);
        $remainingArgumentsCount = $this->numberOfExpectedArguments - count($v);
        // Only part of arguments are given, let's create another currying function for left arguments
        return new self($partiallyCompleteCallable, $remainingArgumentsCount);
    }

    private function noArgumentsAreGiven(array $v): bool
    {
        return empty($v);
    }

    private function isMoreThenExpectedArgumentsGiven(array $v): bool
    {
        return count($v) > $this->numberOfExpectedArguments;
    }

    private function isExpectedNumberOfArgumentsGiven(array $v): bool
    {
        return count($v) === $this->numberOfExpectedArguments;
    }
}