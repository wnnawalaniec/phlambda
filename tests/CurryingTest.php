<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use PHPUnit\Framework\TestCase;
use function Wojciech\Phlambda\curring;
use function Wojciech\Phlambda\curring2;
use function Wojciech\Phlambda\curring3;

class CurryingTest extends TestCase
{
    public function testCurrying(): void
    {
        $currying = curring(fn ($a) => $a + 1);
        $this->assertSame(2, $currying(1));
        $this->assertSame(2, $currying()(1));
    }

    public function testCurrying2(): void
    {
        $currying = curring2(fn ($a, $b) => $a . $b);
        $this->assertSame('ab', $currying('a', 'b'));
        $this->assertSame('ab', $currying()('a')('b'));
        $this->assertSame('ab', $currying()('a', 'b'));
    }

    public function testCurrying3(): void
    {
        $currying = curring3(fn ($a, $b, $c) => $a . $b . $c);
        $this->assertSame('abc', $currying('a', 'b', 'c'));
        $this->assertSame('abc', $currying()('a')('b')('c'));
        $this->assertSame('abc', $currying()('a', 'b', 'c'));
    }
}