<?php
declare(strict_types=1);

namespace Tests\Phlambda\Unit\Internal;

use PHPUnit\Framework\TestCase;
use Phlambda\Internal\Placeholder;
use function Phlambda\__;
use const Phlambda\__;

class PlaceholderTest extends TestCase
{
    public function testIsPlaceholder_PlaceholderConstantGiven_ReturnTrue(): void
    {
        $this->assertTrue(Placeholder::isPlaceholder(__));
    }

    public function testIsPlaceholder_PlaceholderFunctionGiven_ReturnTrue(): void
    {
        $this->assertTrue(Placeholder::isPlaceholder(__()));
    }


    public function testIsPlaceholder_PlaceholderObjectGiven_ReturnTrue(): void
    {
        $this->assertTrue(Placeholder::isPlaceholder(Placeholder::create()));
    }
}