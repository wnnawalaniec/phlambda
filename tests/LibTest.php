<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda;

use Wojciech\Phlambda\Internal\ShouldNotBeImplementedInWrapper;
use Wojciech\Phlambda\Wrapper;
use function Wojciech\Phlambda\_;
use function Wojciech\Phlambda\matches;
use function Wojciech\Phlambda\startsWith;

/**
 * This is set of tests ensuring that chosen library guides are respected.
 */
class LibTest extends BaseTest
{
    public function testAllFunctionsWithoutSpecialAttributeAreImplementedInWrapperClass(): void
    {
        $shouldBeImplementedInWrapper = function (string $function): bool {
            $reflectedFunction = new \ReflectionFunction($function);
            return empty($reflectedFunction->getAttributes(ShouldNotBeImplementedInWrapper::class));
        };

        $allFunctionsInNamespace = _(get_defined_functions()['user'])
            ->filter(startsWith('wojciech\phlambda'))
            ->filter($shouldBeImplementedInWrapper)
            ->flatMap(matches('/wojciech\\\\phlambda\\\\\K\w+/'));

        $wrapperReflection = new \ReflectionClass(Wrapper::class);
        $implementedWrapperMethods = _($wrapperReflection->getMethods(\ReflectionMethod::IS_PUBLIC))
            ->flatMap(fn (\ReflectionMethod $r) => $r->name)
            ->map('strtolower');

        $unimplemented = $allFunctionsInNamespace
            ->diff($implementedWrapperMethods);

        $this->assertEmpty($unimplemented->toArray());
    }

    public function testThereIsConstWithNamespaceOfEachFunction(): void
    {
        $allFunctionsInNamespace = _(get_defined_functions()['user'])
            ->filter(startsWith('wojciech\phlambda'))
            ->flatMap(matches('/wojciech\\\\phlambda\\\\\K\w+/'));

        $definedConstantsInNamespace = _(array_keys(get_defined_constants(true)['user']))
            ->filter('is_string')
            ->map('strtolower')
            ->filter(startsWith('wojciech\phlambda'))
            ->flatMap(matches('/wojciech\\\\phlambda\\\\\K\w+/'));

        $this->assertEmpty($allFunctionsInNamespace->diff($definedConstantsInNamespace)->toArray());
    }
}