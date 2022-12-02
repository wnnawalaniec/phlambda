<?php
declare(strict_types=1);

namespace Phlambda\Internal;

use const Phlambda\__;

/**
 * Object used in currying functions to omit some parameter.
 * For example whe have currying function f accepting two arguments a1, a2.
 * It's possible to call it like this: `f(Placeholder::create(), $someValue)` or even simpler
 * `f(__, $someValue)`. In result new currying function will be returned. That function will
 * await only one, the first a1 argument.
 */
final class Placeholder
{
    public static function create(): self
    {
        return new self();
    }

    /**
     * @return bool true value whenever $argument is instance of Placeholder or __ constant (or function)
     */
    public static function isPlaceholder(mixed $argument): bool
    {
        return $argument instanceof Placeholder || $argument === __;
    }

    /**
     * Returns new array without placeholders.
     *
     * @see self::isPlaceholder()
     */
    public static function filterPlaceholders(array $arguments): array
    {
        return \array_filter($arguments, fn ($a) => !self::isPlaceholder($a));
    }
}