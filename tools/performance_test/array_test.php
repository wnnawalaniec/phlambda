<?php
declare(strict_types=1);

use Tools\Phlambda\Stopper;
use function Phlambda\curry;
use function Phlambda\map;
use const Phlambda\toString;

require_once __DIR__ . '/../../vendor/autoload.php';

$randomArray = range(0, 1000000);
shuffle($randomArray);

$stoper = Stopper::create();
$stoper->start();
map(fn ($s) => (string) $s, $randomArray);
$stoper->stop();
echo $stoper->time() . PHP_EOL;

$stoper->start();
map(curry(fn ($s) => (string) $s), $randomArray);
$stoper->stop();
echo $stoper->time() . PHP_EOL;

$stoper->start();
map(toString, $randomArray);
$stoper->stop();
echo $stoper->time() . PHP_EOL;
