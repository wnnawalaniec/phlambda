<?php
declare(strict_types=1);

namespace Wojciech\Phlambda\Internal;

use Wojciech\Phlambda\Wrapper;

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