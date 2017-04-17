<?php
namespace Pigmalion\Parte1\Problem3;

class ClearPar
{
    public function build($cadenaDeSoloParentesis) : string
    {
        $result = '';
        if (strlen($cadenaDeSoloParentesis) <= 1) {
            return '';
        }

        for ($i = 0; $i < strlen($cadenaDeSoloParentesis); ++$i) {
            if (isset($cadenaDeSoloParentesis[$i+1])) {
                if (ord($cadenaDeSoloParentesis[$i]) === 40 && ord($cadenaDeSoloParentesis[$i+1]) === 41) {
                    $result .= $cadenaDeSoloParentesis[$i] . $cadenaDeSoloParentesis[++$i];
                }
            }
        }

        return $result;
    }

}

$input = trim(fgets(STDIN));
echo (new ClearPar())->build($input);