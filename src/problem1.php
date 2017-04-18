<?php
require __DIR__.'/parte1/problem1/ChangeString.php';

use Pigmalion\Parte1\Problem1\ChangeString;

if (php_sapi_name() === 'cli') {
    echo 'Ingrese un texto:' . PHP_EOL;
    $input = trim(fgets(STDIN));
    echo (new ChangeString())->build($input);
}
