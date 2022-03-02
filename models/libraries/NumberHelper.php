<?php

namespace app\models\libraries;

class NumberHelper
{
    static $arrSum = [];
    static $isStop = false;

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
        self::$arrSum[1] = $number;
        for ($i = 2; $i <= $number; $i++) {
            self::$arrSum[$i] = 0;
        }
    }

    private static function genNextSum($number)
    {
        $i = $number;
        // run from the last, if a[i] = 0 | 1, check the next position
        while ($i > 0 && (self::$arrSum[$i] == 1 || self::$arrSum[$i] == 0)) $i--;
        if ($i > 0 && $i <= $number) {
            if (self::$arrSum[$i + 1] <= 1) {
                self::$arrSum[$i] = self::$arrSum[$i] - 1;
                array_push(self::$arrSum, 1);
            } else {
                self::$arrSum[$i] = self::$arrSum[$i] - 1;
                self::$arrSum[$i + 1] = self::$arrSum[$i + 1] + 1;
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
        self::$arrSum = [];
        self::initFirstSum($number);
        while (!self::$isStop) {
            ksort(self::$arrSum);
            $dataset[] = "(" . implode(" ", array_filter(self::$arrSum, function ($value) {
                return $value >= 1;
            })) . ")";
            self::genNextSum($number);
        }
        return $dataset;
    }

    /**
     * genGrayBin(2) = 00 01 11 10
     * genGrayBin(3) = 00 001 011 010 110 111 101 100
     */
    static function genGrayBin($length, $dataset = [])
    {
        // base case
        if ($length <= 0) {
            return;
        }

        // start with one-bit pattern
        array_push($dataset, 0);
        array_push($dataset, 1);

        // Every iteration of the loop, gen 2*$i codes from previously generated $i codes
        for ($i = 2; $i < (1 << $length); $i = $i << 1) {
            // Add previously code again to $dataset
            for ($j=$i-1; $j >= 0; $j--) { 
                array_push($dataset,$dataset[$j]);
            }
            // Append 0 to the first half
            for ($j=0; $j < $i; $j++) { 
                $dataset[$j] = 0 . $dataset[$j];
            }
            // append 1 to the second half
            for ($j=$i; $j < $i*2; $j++) { 
                $dataset[$j] = 1 . $dataset[$j];
            }
        }
        return $dataset;
    }
}
