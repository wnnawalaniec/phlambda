<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use PHPUnit\Framework\TestCase;

class PredicateTest extends TestCase
{
    public function testBelow_ValueIsMatching_ReturnTrue(): void
    {
        $predicate = below(10);
        $matchingValue = 9.99;

        $result = $predicate($matchingValue);

        $this->assertTrue($result);
    }

    public function testBelow_ValueIsNotMatching_ReturnTrue(): void
    {
        $predicate = below(10);
        $matchingValue = 10.01;

        $result = $predicate($matchingValue);

        $this->assertFalse($result);
    }
}