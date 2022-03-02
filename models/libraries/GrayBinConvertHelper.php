<?php

namespace app\models\libraries;

class GrayBinConvertHelper
{
    // Helper function to xor two characters
    private static function xor_c($a, $b)
    {
        return ($a == $b) ? '0' : '1';
    }

    // Helper function to flip the bit
    private static function flip($c)
    {
        return ($c == '0') ? '1' : '0';
    }

    // function to convert binary string
    // to gray string
    static function binarytoGray($binary)
    {
        $gray = "";

        // MSB of gray code is same as
        // binary code
        $gray .= $binary[0];

        // Compute remaining bits, next bit is
        // computed by doing XOR of previous
        // and current in Binary
        for ($i = 1; $i < strlen($binary); $i++) {
            // Concatenate XOR of previous bit
            // with current bit
            $gray .= self::xor_c($binary[$i - 1], $binary[$i]);
        }

        return $gray;
    }

    // function to convert gray code string
    // to binary string
    static function graytoBinary($gray)
    {
        $binary = "";

        // MSB of binary code is same as gray code
        $binary .= $gray[0];

        // Compute remaining bits
        for ($i = 1; $i < strlen($gray); $i++) {
            // If current bit is 0, concatenate
            // previous bit
            if ($gray[$i] == '0')
                $binary .= $binary[$i - 1];

            // Else, concatenate invert of
            // previous bit
            else
                $binary .= self::flip($binary[$i - 1]);
        }

        return $binary;
    }
}
