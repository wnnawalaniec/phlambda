<?php
declare(strict_types=1);

namespace Phlambda\Internal\Attributes;

use Phlambda\Internal\Wrapper;

/**
 * Attribute to mark methods that are not supposed to be implemented by Wrapper.
 *
 * @see Wrapper
 * @codeCoverageIgnore
 */
#[\Attribute]
class ShouldNotBeImplementedInWrapper
{
}