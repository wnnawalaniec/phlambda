<?php
declare(strict_types=1);

use Tools\Phlambda\Stopper;

require_once __DIR__ . '/../../vendor/autoload.php';

$stoper = Stopper::create();
$stoper->start();
for ($x = 0; $x < 100000; $x++) {
    $val = range(1, 2);
    $sum = 0;
    foreach ($val as $v) {
        $sum += $v;
    }
}
$stoper->stop();
echo $stoper->time() . PHP_EOL;


$stoper->start();
for ($x = 0; $x < 100000; $x++) {
    $val = range(1, 2);
    Phlambda\sum($val);
}
$stoper->stop();
echo $stoper->time() . PHP_EOL;