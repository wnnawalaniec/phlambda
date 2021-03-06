<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda\Support;

trait ExceptionAssertions
{
    private function assertException(\Exception $expectedException, callable $act): void
    {
        $this->expectExceptionObject($expectedException);
        $act();
    }
}