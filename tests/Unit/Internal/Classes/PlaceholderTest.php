<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda\Unit\Internal\Classes;

use PHPUnit\Framework\TestCase;
use Wojciech\Phlambda\Internal\Classes\Placeholder;
use function Wojciech\Phlambda\__;
use const Wojciech\Phlambda\__;

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