<?php

namespace app\models\libraries;

class Combination
{
    static $initArray = [];
    static $diffCombination = [];
    static $isStop = false;
    static $countDiffCombination = 0;
    /**
     * generate([1,2], 2)
     *  results
     *    11, 12, 21, 22
     */
    static function generateAllCombination($array, $size, $combinations = [])
    {

        # if it's the first iteration, the first set 
        # of combinations is the same as the set of characters
        if (empty($combinations)) {
            $combinations = $array;
        }

        # we're done if we're at size 1
        if ($size == 1) {
            return $combinations;
        }

        # initialise array to put new values in
        $new_combinations = array();

        # loop through existing combinations and character set to create strings
        foreach ($combinations as $combination) {
            foreach ($array as $char) {
                $new_combinations[] = $combination . $char;
            }
        }

        # call same function again for the next iteration
        return self::generateAllCombination($array, $size - 1, $new_combinations);
    }


    private static function initFirstCombination($k, $n)
    {
        for ($i = 1; $i <= $k; $i++) {
            self::$initArray[$i] = $i;
        }
    }

    /**
     * findNextCombination(3,5,[1,4,5]) => 2,3,4
     * findNextCombination(3,5,[3,4,5]) => 1,2,3
     */
    static function findNextCombination($k, $n, $currentCombination = [])
    {
        $countFalse = 0;
        for ($i = $k - 1; $i >= 0; $i--) {
            // 1,4,5 => 5 < 5 - 3 + 2 + 1 => false++
            // 1,4,5 => 4 < 5-3+1+1 => false++
            //1,4,5 => 1 < 5-3+0+1 => true 
            //                    1++
            //                    for 1->2
            //                    a[1] = a[0]+1 = 2+1 = 3
            //                    a[2] = a[1]+1 = 3+1 = 4
            if ($currentCombination[$i] < $n - $k + $i + 1) {
                $currentCombination[$i]++;
                for ($j = $i + 1; $j < $k; $j++) {
                    $currentCombination[$j] = $currentCombination[$j - 1] + 1;
                }
            } else {
                $countFalse++;
            }
        }
        // if found any combination
        if ($countFalse < $k) {
            return $currentCombination;
        } else {
            // after the last combination, return the first combination
            self::initFirstCombination($k, $n);
            return self::$initArray;
        }
    }

    /**
     * Gen next combination from initArray
     */
    private static function genNextDiffCombination($k, $n)
    {
        $i = intval($k);
        while ($i > 0 && self::$initArray[$i] == $n - $k + $i) {
            $i--;
        }

        if ($i > 0) {
            ++self::$initArray[$i];
            for ($j = $i + 1; $j <= $k; $j++) {
                self::$initArray[$j] = self::$initArray[$j - 1] + 1;
            }
        } else {
            self::$isStop = true;
        }
    }

    /**
     * Gen all combinations $k number with the max number is $n
     * ex. genDiffCombination(3,5) => 123 124 125 132 134 ... 345
     */
    static function genDiffCombination($k, $n, $dataset = [])
    {
        self::$isStop = false; // after the first loop to gen all combination, the status should be true to stop
        self::initFirstCombination($k, $n);
        while (!self::$isStop) {
            $dataset[] = implode("", self::$initArray);
            self::genNextDiffCombination($k, $n);
        }
        return $dataset;
    }
}
