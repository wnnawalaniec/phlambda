<?php
declare(strict_types=1);

function all(array $arr, callable $fn): array
{
    return array_filter($arr, $fn);
}