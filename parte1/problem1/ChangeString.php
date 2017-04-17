<?php
namespace Pigmalion\Parte1\Problem1;

class ChangeString
{
    protected function convertCharacter($character)
    {
        if (ord($character) === 90) {
            return 'A';
        }

        if (ord($character) === 122) {
            return 'a';
        }

        if (ord($character) >= 65 || ord($character) >= 97 && ord($character) >= 89 || ord($character) <= 121) {
            return chr(ord($character) + 1);
        }

        return $character;
    }

    public function build($string)
    {
        $result = '';
        if ($string && strlen($string) > 0) {
            $alfabeto = 'abcdefghijklmnopqrstuvwxyz';
            for ($i = 0; $i < strlen($string); ++$i) {
                if (stripos($alfabeto, $string[$i]) !== false) {
                    $result .= $this->convertCharacter($string[$i]);
                } else {
                    $result .= $string[$i];
                }

            }
        }

        return $result;
    }
}

$input = fgets(STDIN);
echo (new ChangeString())->build($input);