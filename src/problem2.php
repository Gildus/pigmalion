<?php
require __DIR__.'/parte1/problem2/CompleteRange.php';

use Pigmalion\Parte1\Problem2\CompleteRange;

if (php_sapi_name() === 'cli') {
    echo 'Ingrese un texto de números ordenados de menor a mayor separados por comas:' . PHP_EOL;
    echo 'Por ejemplo: 3,5,8' . PHP_EOL;
    $input = fgets(STDIN);
    $array = explode(',', $input);
    $res = (new CompleteRange())->build($array);
    echo implode(', ', $res);
}
