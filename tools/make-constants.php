<?php
declare(strict_types=1);

namespace Tools\Wojciech\Phlambda;

use function Wojciech\Phlambda\_;
use function Wojciech\Phlambda\matches;
use function Wojciech\Phlambda\startsWith;

require_once __DIR__ . '/../vendor/autoload.php';

const target_namespace = 'Wojciech\Phlambda';

$file = new \Nette\PhpGenerator\PhpFile();
$file->addComment('This file is auto-generated.');
$file->setStrictTypes();
$file->addNamespace(target_namespace);

$declaredFunctions = _(get_defined_functions()['user'])
    ->filter(startsWith(strtolower(target_namespace)))
    ->flatMap(fn (string $name) => (new \ReflectionFunction($name))->getName())
    ->flatMap(matches('/Wojciech\\\\Phlambda\\\\\K\w+/'))
    ->toArray();

$fileContent = (string) $file;

foreach ($declaredFunctions as $function) {
    $fileContent .= sprintf('const %s = "\%s\%s"; ' . PHP_EOL, $function, target_namespace, $function);
}

file_put_contents(__DIR__ . '/../src/constants.php', $fileContent);
