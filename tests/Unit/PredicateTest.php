<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda\Unit;

use Wojciech\Phlambda\Internal\Classes\Placeholder;
use function Wojciech\Phlambda\above;
use function Wojciech\Phlambda\below;
use function Wojciech\Phlambda\ofType;

class PredicateTest extends BaseTest
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

    public function testOfType(): void
    {
        $this->assertTrue(ofType('int')(1));
        $this->assertFalse(ofType('int')('1'));
        $this->assertTrue(ofType('string')('1'));
        $this->assertFalse(ofType('string')(1));
        $this->assertTrue(ofType('float')(1.1));
        $this->assertFalse(ofType('float')(1));
        $this->assertTrue(ofType('array')([1]));
        $this->assertFalse(ofType('array')(1));
        $this->assertTrue(ofType('bool')(true));
        $this->assertFalse(ofType('bool')(1));
        $this->assertTrue(ofType('object')(new \stdClass()));
        $this->assertFalse(ofType('object')([]));
        $this->assertTrue(ofType(Placeholder::class)(Placeholder::create()));
        $this->assertFalse(ofType(Placeholder::class)(new \stdClass()));
    }
}