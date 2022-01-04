<?php
declare(strict_types=1);

namespace Wojciech\Phlambda\Classes;

interface MathCapabilities
{
    public function add(float $num1, float $num2): float;

    public function dec(float|int $num): float;

    public function inc(float|int $num): float;

    public function divide(float|int $num1, float|int $num2): float;

    public function multiply(float|int $num1, float|int $num2): float;

    public function sum(array $arr): float;
}