<?php
declare(strict_types=1);

namespace Tools\Phlambda;

use function Phlambda\_;
use function Phlambda\matches;
use function Phlambda\startsWith;

require_once __DIR__ . '/../vendor/autoload.php';

const target_namespace = 'Phlambda';

$file = new \Nette\PhpGenerator\PhpFile();
$file->addComment('This file is auto-generated (`make generate-constants`)');
$file->setStrictTypes();
$file->addNamespace(target_namespace);

$declaredFunctions = _(get_defined_functions()['user'])
    ->filter(startsWith(strtolower(target_namespace)))
    ->flatMap(fn (string $name) => (new \ReflectionFunction($name))->getName())
    ->flatMap(matches('/Phlambda\\\\\K\w+/'))
    ->toArray();

$fileContent = (string) $file;

foreach ($declaredFunctions as $function) {
    $fileContent .= sprintf('const %s = \'\%s\%s\'; ' . PHP_EOL, $function, target_namespace, $function);
}

file_put_contents(__DIR__ . '/../src/constants.php', $fileContent);
