<?php

namespace app\models\libraries;

class NumberHelper
{
    public static function getNextBinaryNumber($number)
    {
        $len = strlen(trim($number));

        // examine bits from the right
        for ($i = $len - 1; $i >= 0; $i--) {
            // if '0' is encountered, convert
            // it to '1' and then break
            if ($number[$i] == '0') {
                $number[$i] = '1';
                break;
            }

            // else convert '1' to '0'
            else
                $number[$i] = '0';
        }
        // if ($i < 0) {
        //     $number = "1" . $number;
        // }

        // final binary representation
        // of the required integer
        return $number;
    }
}
