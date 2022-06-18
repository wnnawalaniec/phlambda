<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda\Unit;

use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected function assertFunctionHasAttribute(string $attributeClass, string $function): void
    {
        $this->assertNotEmpty((new \ReflectionFunction($function))->getAttributes($attributeClass));
    }
}