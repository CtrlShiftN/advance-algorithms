<?php

namespace app\models\libraries;

class CharacterHelper
{
    static $binaryNumberAsArray = [];
    static $isStop = false;

    private static function initFirstBinaryString($length)
    {
        for ($i = 1; $i <= $length; $i++) {
            self::$binaryNumberAsArray[$i] = 0;
        }
    }

    private static function genNextBinaryString($length)
    {
        $i = $length;
        while ($i > 0 && self::$binaryNumberAsArray[$i] == 1) {
            self::$binaryNumberAsArray[$i] = 0;
            $i--;
        }
        if ($i <= 0) {
            self::$isStop = true;
        } else {
            self::$binaryNumberAsArray[$i] = 1;
            for ($j = $i + 1; $j <= $length; $j++) {
                self::$binaryNumberAsArray[$j] = 0;
            }
        }
    }

    static function genBinary($length, $dataset = [])
    {
        self::$isStop = false;
        self::initFirstBinaryString($length);
        while (!self::$isStop) {
            $dataset[] = implode("", self::$binaryNumberAsArray);
            self::genNextBinaryString($length);
        }
        return $dataset;
    }

    /**
     * Count the occurrence of a certain value from an array
     */
    private static function countContinuousOccurrence($array, $searchingValue)
    {
        $maxOccurence = 1;
        $countOccurrence = 0;
        for ($i = 1; $i <= count($array); $i++) {
            if ($array[$i] == $searchingValue) {
                $countOccurrence++;
            } else {
                if ($countOccurrence > $maxOccurence) {
                    $maxOccurence = $countOccurrence;
                }
                $countOccurrence = 0;
            }
        }
        return $maxOccurence > $countOccurrence ? $maxOccurence : $countOccurrence;
    }
    static function genBinaryWithContinuousOccurrence($length, $occurrence, $dataset = [])
    {
        self::$isStop = false;
        self::initFirstBinaryString($length);
        while (!self::$isStop) {
            if (self::countContinuousOccurrence(self::$binaryNumberAsArray, 1) == $occurrence) {
                $dataset[] = implode("", self::$binaryNumberAsArray);
            }
            self::genNextBinaryString($length);
        }
        return array_reverse($dataset);
    }

    private static function replaceAAndBIntoBinChar($binaryArray, $dataset = [])
    {
        foreach ($binaryArray as $key => $value) {
            foreach (str_split($value) as $index => $item) {
                $dataset[$key][$index] = $item == 1 ? "A" : "B";
            }
            $dataset[$key] = implode("", $dataset[$key]);
        }
        return $dataset;
    }

    static function getSpecialAB($length, $occurrence, $dataset = [])
    {
        $dataset = self::genBinaryWithContinuousOccurrence($length, $occurrence);
        return self::replaceAAndBIntoBinChar($dataset);
    }
}
