<?php
namespace Pigmalion\Parte1\Problem2;

class CompleteRange
{
    /**
     * Completando numeros que faltan. Además, conciderando
     * que la coleccion o array esten ordenados de menor a
     * mayor.
     *
     * @param array $numeros
     * @return array
     */
    public function build(array $numeros) :array
    {
        $res = [];
        for ($i = $numeros[0]; $i <= $numeros[count($numeros)-1]; ++$i ) {
            $res[] = (int) $i;
        }

        return $res;
    }

}
/// 1,4,5,8
$input = fgets(STDIN);
$array = explode(',', $input);
$res = (new CompleteRange())->build($array);
echo implode(', ', $res);