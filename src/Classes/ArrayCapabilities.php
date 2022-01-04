<?php
declare(strict_types=1);

namespace Wojciech\Phlambda\Classes;

interface ArrayCapabilities
{
    function all(callable $fn): static;
}