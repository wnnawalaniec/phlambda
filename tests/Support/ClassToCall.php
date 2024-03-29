<?php
declare(strict_types=1);

namespace Tests\Wojciech\Phlambda\Support;

class ClassToCall
{
    public static function staticCall(): string
    {
        return 'static';
    }

    public static function call(): string
    {
        return 'call';
    }
}