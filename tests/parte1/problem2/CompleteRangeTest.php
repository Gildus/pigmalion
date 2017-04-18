<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pigmalion\Parte1\Problem2\CompleteRange;

class CompleteRangeTest extends TestCase
{
    public function testBuild()
    {
        $inputs = [
            [1, 2, 4, 5],
            [2, 4, 9],
            [55, 58, 60],
        ];
        $output = [];
        $expected = [
            [1, 2, 3, 4, 5],
            [2, 3, 4, 5, 6, 7, 8, 9],
            [55, 56, 57, 58, 59, 60],
        ];

        $problem = new CompleteRange();
        foreach ($inputs as $input) {
            $output[] = $problem->build($input);
        }

        $this->assertEquals($expected, $output);
    }
}
