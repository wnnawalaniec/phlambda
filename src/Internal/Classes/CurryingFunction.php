<?php
declare(strict_types=1);

namespace Wojciech\Phlambda\Internal\Classes;

use Wojciech\Phlambda\Internal\Exceptions\TooMuchArgumentsGiven;

/**
 * Internal class that encapsulates currying functions generation and logic.
 * currying function is a function which accepts some arguments and allows to
 * partially fill those arguments in steps.
 *
 * Example of currying function f(a1, a2): `f(a1)(a2);`
 */
class CurryingFunction
{
    public function __construct(private \Closure $callable, private int $numberOfExpectedArguments)
    {
        $this->passedArguments = array_fill(0, $numberOfExpectedArguments, Placeholder::create());
    }

    /**
     * Depend on number of expected arguments given in constructor and number of arguments
     * given to this method, 3 things can happen:
     *  - when number of arguments equals expected number, given callable will be called with all arguments and result
     * will be returned.
     *  - when 0 arguments are passed, just instance of called object is returned
     *  - when less than expected number of arguments are given, another Curry object is created expecting rest of arguments
     *
     * Keep in mind, that calling currying function with just some arguments will result in creation of new instance of
     * currying function.
     *
     * @throws TooMuchArgumentsGiven when more than expected number of arguments are given
     */
    public function __invoke(...$arguments)
    {
        if ($this->isMoreThenExpectedArgumentsGiven($arguments))
            throw TooMuchArgumentsGiven::create($this->numberOfExpectedArguments());
        if ($this->areAllPassed()) return ($this->callable)(...$this->passedArguments);
        if ($this->noArgumentsAreGiven($arguments)) return $this;
        $new = clone $this;
        $new->updatePassedArguments($arguments);
        return $new();
    }

    private function isMoreThenExpectedArgumentsGiven(array $arguments): bool
    {
        return count($arguments) > $this->numberOfExpectedArguments();
    }

    private function numberOfExpectedArguments(): int
    {
        return $this->numberOfExpectedArguments;
    }

    private function areAllPassed(): bool
    {
        return count(Placeholder::filterPlaceholders($this->passedArguments)) === $this->numberOfExpectedArguments();
    }

    private function noArgumentsAreGiven(array $arguments): bool
    {
        return empty($arguments) || empty(Placeholder::filterPlaceholders($arguments));
    }

    private function updatePassedArguments(array $arguments): void
    {
        $numberOfPlaceholdersToSkip = 0;
        foreach ($arguments as $argument) {
            if (Placeholder::isPlaceholder($argument)) {
                $numberOfPlaceholdersToSkip++;
                continue;
            }

            $this->replacePlaceholderWithArgument($argument, $numberOfPlaceholdersToSkip);
        }
    }

    private function replacePlaceholderWithArgument(mixed $argument, int $placeholdersToSkip): void
    {
        foreach ($this->passedArguments as $key => $passedArgument) {
            if (!Placeholder::isPlaceholder($passedArgument)) continue;

            if ($placeholdersToSkip > 0) {
                --$placeholdersToSkip;
                continue;
            }

            $this->passedArguments[$key] = $argument;
            return;
        }
    }

    protected array $passedArguments;
}