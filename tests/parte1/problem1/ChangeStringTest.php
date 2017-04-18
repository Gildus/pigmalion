<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pigmalion\Parte1\Problem1\ChangeString;

class ChangeStringTest extends TestCase
{
    public function testBuild()
    {
        $inputs = [
            '123 abcd*3*',
            '**Casa 52',
            '**Casa 52Z',
        ];
        $output = [];
        $expected = [
            '123 bcde*3*',
            '**Dbtb 52',
            '**Dbtb 52A',
        ];

        $problem = new ChangeString();
        foreach ($inputs as $input) {
            $output[] = $problem->build($input);
        }

        $this->assertEquals($expected, $output);
    }
}
