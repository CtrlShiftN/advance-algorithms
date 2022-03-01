<?php

namespace app\models\libraries;

class Permutation
{
    static $initArray = [];
    static $isStop = false;

    /**
     * genNextPermutationFromArray([1,2,3,4,5]) => 1,2,3,5,4
     * genNextPermutationFromArray([5,4,3,2,1]) => 1,2,3,4,5
     */
    static function genNextPermutationFromArray($currentPermutationArray)
    {
        // Length of the array
        $len = count($currentPermutationArray);
        // Index of the first element that is smaller than
        // the element to its right.
        $firstIndex = -1;
        // Loop from right to left
        for ($i = $len - 1; $i > 0; $i--) {
            if ($currentPermutationArray[$i] > $currentPermutationArray[$i - 1]) {
                $firstIndex = $i - 1;
                break;
            }
        }
        // Base condition
        if ($firstIndex == -1) {
            $newArray = ArrayProHelper::swap($currentPermutationArray, 0, $len - 1);
            $newArray = ArrayProHelper::reverse($newArray, 1, $len - 2);
            return $newArray;
        }
        $j = $len - 1;
        // Again swap from right to left to find first element
        // that is greater than the above find element
        for ($i = $len - 1; $i >= $firstIndex + 1; $i--) {
            if ($currentPermutationArray[$i] > $currentPermutationArray[$firstIndex]) {
                $j = $i;
                break;
            }
        }
        // Swap the elements
        $newArray = ArrayProHelper::swap($currentPermutationArray, $firstIndex, $j);
        // Reverse the elements from index + 1 to the nums.length
        $newArray = ArrayProHelper::reverse($newArray, $firstIndex + 1, $len - 1);
        return $newArray;
    }

    /**
     * gen initArray as [1,2,3,...,$length]
     */
    private static function initFirstPermutation($length)
    {
        for ($i = 1; $i <= $length; $i++) {
            self::$initArray[$i] = $i;
        }
    }

    /**
     * Gen next permutation from initArray
     */
    private static function genNextPermutation($length)
    {
        $i = $length - 1;
        // if a[i] > a[i+1], check a[i-1]
        while ($i > 0 && self::$initArray[$i] > self::$initArray[$i + 1]) {
            $i--;
        }
        if ($i > 0) {
            $j = $length;
            // find the number that only smaller than the current number
            while (self::$initArray[$j] < self::$initArray[$i]) {
                $j--;
            }
            NumberHelper::swapTwoVarValues(self::$initArray[$j], self::$initArray[$i]);
            // change position for the rest
            $left = $i + 1;
            $right = $length;
            while ($left < $right) {
                NumberHelper::swapTwoVarValues(self::$initArray[$left], self::$initArray[$right]);
                $left++;
                $right--;
            }
        } else {
            self::$isStop = true;
        }
    }

    /**
     * genAllDiffPermutation(2) = 12 21
     * genAllDiffPermutation(3) = 123 132 213 231 312 321
     */
    static function genAllDiffPermutation($length, $dataset = [])
    {
        self::$isStop = false; // after the first loop to gen all combination, the status should be true to stop
        self::initFirstPermutation($length);
        while (!self::$isStop) {
            $dataset[] = implode("", self::$initArray);
            self::genNextPermutation($length);
        }
        return $dataset;
    }
}
