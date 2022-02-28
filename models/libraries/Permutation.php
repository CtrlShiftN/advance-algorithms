<?php

namespace app\models\libraries;

class Permutation
{
    /**
     * genNextPermutation([1,2,3,4,5]) => 1,2,3,5,4
     * genNextPermutation([5,4,3,2,1]) => 1,2,3,4,5
     */
    static function genNextPermutation($currentPermutationArray)
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
}
