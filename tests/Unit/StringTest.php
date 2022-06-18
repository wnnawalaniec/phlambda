<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda\Unit;

use function Wojciech\Phlambda\endsWith;
use function Wojciech\Phlambda\matches;
use function Wojciech\Phlambda\startsWith;
use function Wojciech\Phlambda\toString;

class StringTest extends BaseTest
{
    public function testToString(): void
    {
        $stringable = new class () implements \Stringable {
            public function __toString(): string
            {
                return '1';
            }
        };
        $this->assertSame('1', toString(1));
        $this->assertSame('1', toString(true));
        $this->assertSame('', toString(null));
        $this->assertSame('1', toString($stringable));
    }

    public function testStartsWith(): void
    {
        $this->assertSame(true, startsWith('Lorem ipsum', 'Lorem ipsum 123'));
        $this->assertSame(true, startsWith(' Lorem ipsum', ' Lorem ipsum 123'));
        $this->assertSame(false, startsWith('lorem', 'Lorem ipsum 123'));
        $this->assertSame(false, startsWith(' Lorem', 'Lorem ipsum 123'));
        $this->assertSame(true, startsWith('Żó', 'Żółć'));
        $this->assertSame(false, startsWith('Żó', 'Zolc'));
    }

    public function testEndsWith(): void
    {
        $this->assertSame(true, endsWith('oo', 'Foo'));
        $this->assertSame(true, endsWith('oo ', 'Foo '));
        $this->assertSame(false, endsWith('oo ', 'Foo'));
        $this->assertSame(false, endsWith('O', 'Foo'));
        $this->assertSame(true, endsWith('ółć', 'Żółć'));
        $this->assertSame(false, endsWith('ć', 'Zolc'));
    }

    public function testMatches(): void
    {
        $this->assertSame(['ba', 'na', 'na'], matches('/([a-z]a)/', 'bananas'));
        $this->assertSame([], matches('/a/', 'b'));
    }
}