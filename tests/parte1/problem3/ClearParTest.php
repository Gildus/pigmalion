<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pigmalion\Parte1\Problem3\ClearPar;

class ClearParTest extends TestCase
{
    public function testBuild()
    {
        $inputs = [
            '()())()',
            '()(()',
            ')(',
            '((()',
        ];
        $output = [];
        $expected = [
            '()()()',
            '()()',
            '',
            '()',
        ];

        $problem = new ClearPar();
        foreach ($inputs as $input) {
            $output[] = $problem->build($input);
        }

        $this->assertEquals($expected, $output);
    }
}
