<?php
require __DIR__.'/parte1/problem3/ClearPar.php';

use Pigmalion\Parte1\Problem3\ClearPar;

if (php_sapi_name() === 'cli') {
    echo 'Ingrese un texto con solo simbolos de paréntesis:' . PHP_EOL;
    echo 'Por ejemplo (((())(()()()):' . PHP_EOL;
    $input = trim(fgets(STDIN));
    echo (new ClearPar())->build($input);
}
