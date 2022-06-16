<?php
declare(strict_types=1);

namespace Wojciech\Phlambda\Internal\Exceptions;

class TooMuchArgumentsGiven extends \RuntimeException
{
    public static function create(int $expectedNumber): self
    {
        return new self(sprintf('Function is expecting %d arguments only', $expectedNumber));
    }
}