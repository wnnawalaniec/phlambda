<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use PHPUnit\Framework\TestCase;
use function Wojciech\Phlambda\above;
use function Wojciech\Phlambda\below;

class PredicateTest extends TestCase
{
    public function testBelow(): void
    {
        $this->assertTrue(below(10)(9.9));
        $this->assertFalse(below(10)(10));
    }

    public function testAbove(): void
    {
        $this->assertTrue(above(10)(10.1));
        $this->assertFalse(above(10)(10));
    }
}