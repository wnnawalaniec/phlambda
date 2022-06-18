<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda\Unit;

use function Wojciech\Phlambda\clamp;

class RelationTest extends BaseTest
{
    public function testClamp(): void
    {
        $this->assertSame(1, clamp(1, 10, 0));
        $this->assertSame(10, clamp(1, 10, 11));
        $this->assertSame(5, clamp(1, 10, 5));
        $this->assertSame(1, clamp(1, 1, 5));
        $this->assertSame('b', clamp('b', 'd', 'a'));
        $this->assertSame('d', clamp('b', 'd', 'e'));
        $this->assertSame('c', clamp('b', 'd', 'c'));
        $this->assertEquals(
            new \DateTimeImmutable('01-01-2022'),
            clamp(
                new \DateTimeImmutable('01-01-2022'),
                new \DateTimeImmutable('31-12-2022'),
                new \DateTimeImmutable('31-12-2021')
            )
        );
        $this->assertEquals(
            new \DateTimeImmutable('31-12-2022'),
            clamp(
                new \DateTimeImmutable('01-01-2022'),
                new \DateTimeImmutable('31-12-2022'),
                new \DateTimeImmutable('01-01-2023')
            )
        );
    }

    public function testClamp_MinIsGreaterThanMax_ThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        clamp(10, 1, 1);
    }
}