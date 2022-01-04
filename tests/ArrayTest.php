<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
    public function testAll(): void
    {
        $array = [9.99, 10, 10.01];

        $value = all($array, below(10));

        $expectedValue = [9.99];
        $this->assertSame($expectedValue, $value);
    }
}