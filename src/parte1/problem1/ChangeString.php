<?php
namespace Pigmalion\Parte1\Problem1;

class ChangeString
{
    protected function convertCharacter($character) : string
    {
        if (ord($character) === 90) {
            return 'A';
        }

        if (ord($character) === 122) {
            return 'a';
        }

        if (ord($character) >= 65 && ord($character) <= 89 || ord($character) >= 97  && ord($character) <= 121) {
            return chr(ord($character) + 1);
        }

        return $character;
    }

    public function build($string) : string
    {
        $result = '';
        if ($string && strlen($string) > 0) {
            for ($i = 0; $i < strlen($string); ++$i) {
                $result .= $this->convertCharacter($string[$i]);
            }
        }

        return $result;
    }
}

// Examples:
// Input: 123 abcd*3*       Output: 123 bcde*3*
// Input: **Casa 52       Output: **Dbtb 52

$input = fgets(STDIN);
echo (new ChangeString())->build($input);