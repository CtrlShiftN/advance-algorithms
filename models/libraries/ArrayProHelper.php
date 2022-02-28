<?php

namespace app\models\libraries;

class ArrayProHelper
{
    static function reverse($array, $fromIndex, $toIndex)
    {
        $newArray = array_map('intval', $array);
        while ($fromIndex < $toIndex) {
            $newArray = self::swap($newArray, $fromIndex, $toIndex);
            $fromIndex++;
            $toIndex--;
        }
        return $newArray;
    }
    /**
     * Swap position of two elements in an array
     * $arr = [1,3,4] 
     * swap($arr,1,2) => [1,4,3]
     */
    static function swap($array, $searchingIndex, $replacementIndex)
    {
        $newArray = array_map('intval', $array);
        $newArray[$searchingIndex] = $array[$replacementIndex];
        $newArray[$replacementIndex] = $array[$searchingIndex];
        return $newArray;
    }
}
