<?php
declare(strict_types=1);

namespace Wojciech\Phlambda\Classes;

use JetBrains\PhpStorm\Pure;
use Wojciech\Phlambda as f;

class ArrayWrapper implements \ArrayAccess, MathCapabilities, ArrayCapabilities
{
    private array $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public static function wrap(array $array): self
    {
        return new self($array);
    }

    public function offsetExists(mixed $offset)
    {
        return isset($this->array[$offset]);
    }

    public function offsetGet(mixed $offset)
    {
        return $this->array[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value)
    {
        $offset ? $this->array[$offset] = $value : $this->array[] = $value;
    }

    public function offsetUnset(mixed $offset)
    {
        unset($this->array[$offset]);
    }

    public function toArray(): array
    {
        return $this->array;
    }

    #[Pure] public function add(float $num1, float $num2): float
    {
        return f\add($num1, $num2);
    }

    #[Pure] public function dec(float|int $num): float
    {
        return f\dec($num);
    }

    #[Pure] public function inc(float|int $num): float
    {
        return f\inc($num);
    }

    #[Pure] public function divide(float|int $num1, float|int $num2): float
    {
        return f\divide($num1, $num2);
    }

    #[Pure] public function multiply(float|int $num1, float|int $num2): float
    {
        return f\multiply($num1, $num2);
    }

    public function sum(array $arr): float
    {
        return f\sum($arr);
    }

    function all(callable $fn): static
    {
        return self::wrap(f\all($this->array, $fn));
    }
}