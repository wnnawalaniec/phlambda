<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda\Classes;

use PHPUnit\Framework\TestCase;
use Wojciech\Phlambda\Classes\ArrayWrapper;
use Wojciech\Phlambda as f;

class ArrayWrapperTest extends TestCase
{
    public function testAll(): void
    {
        $array = [1, 1.1, '1.2'];

        $value = ArrayWrapper::wrap($array)
            ->all(f\below(1.1))
            ->toArray();

        $expectedValue = [1];
        $this->assertEquals($expectedValue, $value);
    }
}