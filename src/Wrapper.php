<?php
declare(strict_types=1);

namespace Wojciech\Phlambda;

/**
 * This class is a wrapper for arrays, so you can chain functions from that library in nice fashion.
 *
 * Example:
 * <blockquote><pre>
 * Wrapper::wrap([1,2,3,4,5])
 *   ->all(above(2))
 *   ->drop(1)
 *   ->reduce(add(), 0);
 * </blockquote></pre>
 *
 * You can use `_()` function instead of `Wrapper::wrap()`;
 *
 * @see _()
 */
class Wrapper implements \ArrayAccess
{
    public function __construct(private array $array = []) {}

    public static function wrap(array $array): self
    {
        return new self($array);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->array[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->array[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $offset ? $this->array[$offset] = $value : $this->array[] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->array[$offset]);
    }

    public function toArray(): array
    {
        return $this->array;
    }

    /**
     * Return copy of an array with replaced element at given index.
     *
     * @see adjust()
     */
    public function adjust(callable $fn, int $idx): self
    {
        return self::wrap(adjust($fn, $idx, $this->array));
    }

    /**
     * Returns true if all elements from the array match the predicate, false if
     * there is any which doesn't.
     *
     * @see all()
     */
    public function all(callable $fn): bool
    {
        return all($fn, $this->array);
    }

    /**
     * Return true if any element matches given predicate.
     *
     * @see any()
     */
    public function any(callable $fn): bool
    {
        return any($fn, $this->array);
    }

    /**
     * Return copy of an array with given element appended at the end.
     *
     * @see append()
     */
    public function append(mixed $item): self
    {
        return self::wrap(append($item, $this->array));
    }

    /**
     * Concat this array with given one (Wrapper may be passed too).
     *
     * @see concat()
     */
    public function concat(array|Wrapper $array): self
    {
        return self::wrap(concat($this->array, ($array instanceof Wrapper ? $array->toArray() : $array)));
    }

    public function diff(array|Wrapper $array): self
    {
        return self::wrap(diff($this->array, ($array instanceof  Wrapper ? $array->toArray() : $array)));
    }

    /**
     * Return copy but without first `n` elements of the given `input`.
     *
     * @see drop()
     */
    public function drop(int $n): self
    {
        return self::wrap(drop($n, $this->array));
    }

    /**
     * Return copy but without `n` last elements of the given `input`.
     *
     * @see dropLast()
     */
    public function dropLast(int $n): self
    {
        return self::wrap(dropLast($n, $this->array));
    }

    /**
     * Returns list with only values matching given predicate.
     *
     * @see filter
     */
    public function filter(callable $fn): self
    {
        return self::wrap(filter($fn, $this->array));
    }

    /**
     * Return copy but without repeating elements.
     *
     * @see dropRepeats()
     */
    public function dropRepeats(): self
    {
        return self::wrap(dropRepeats($this->array));
    }

    /**
     * Applies given function to each element of the array and return new one with the results flatten to single dimension.
     *
     * @see flatMap()
     */
    public function flatMap(callable $fn): self
    {
        return self::wrap(flatMap($fn, $this->array));

    }

    /**
     * Applies given function to each element of the array and return new one with the results.
     *
     * @see map()
     */
    public function map(callable $fn): self
    {
        return self::wrap(map($fn, $this->array));
    }

    /**
     * Reduces array to single value using provided callback.
     *
     * @see reduce()
     */
    public function reduce(callable $fn, mixed $initialValue): mixed
    {
        return reduce($fn, $initialValue, $this->array);
    }
}