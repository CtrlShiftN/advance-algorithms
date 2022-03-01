<?php

namespace app\models\libraries;

class NumberHelper
{
    static $arrSum = [];
    static $isStop = false;
    static $k;

    /**
     * getNextBinaryNumber(010101) = 010110
     * getNextBinaryNumber(111111) = 000000
     */
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

    /**
     *  a = 1, b = 2
     * swapTwoVarValues(a,b) 
     *      => a = 2, b = 1
     */
    static function swapTwoVarValues(&$firstNumber, &$secondNumber)
    {
        $temp = $firstNumber;
        $firstNumber = $secondNumber;
        $secondNumber = $temp;
    }

    /**
     * first sum = [$number, 0, ... , 0]
     */
    private static function initFirstSum($number)
    {
        self::$k = 1;
        self::$arrSum[self::$k] = $number;
    }

    private static function genNextSum($number)
    {
        $i = self::$k;
        // run from the last, if a[i] = 0 | 1, check the next position
        while ($i > 0 && (self::$arrSum[$i] == 1)) $i--;
        if ($i > 0) {
            self::$arrSum[$i] = self::$arrSum[$i] - 1;
            $D = self::$k - $i + 1;
            $R = $D / self::$arrSum[$i];
            $S = $D % self::$arrSum[$i];
            self::$k = $i;
            if ($R > 0) {
                for ($j = $i + 1; $j <= $i + $R; $j++) {
                    self::$arrSum[$j] = self::$arrSum[$i];
                }
                self::$k = self::$k + $R;
            }
            if ($S > 0) {
                self::$k = self::$k + 1;
                self::$arrSum[self::$k] = $S;
            }
        } else {
            self::$isStop = true;
        }
    }

    /**
     * genAllSumFactors(4) = (4), (3 1), (2 2), (2 1 1), (1 1 1 1)
     */
    static function genAllSumFactors($number, $dataset = [])
    {
        self::$isStop = false;
        self::initFirstSum($number);
        while (!self::$isStop) {
            ksort(self::$arrSum);
            $dataset[] = implode(" ", self::$arrSum);
            self::genNextSum($number);
        }
        return $dataset;
    }
}
