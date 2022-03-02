<?php

namespace app\models\libraries;

use SplFileObject;

class FileHelper
{
    /**
     * Read each line from a file as an array element
     */
    public static function readFileByLineAsArray($filepath)
    {
        $arrContent = [];
        $count = 0;
        $file = new SplFileObject($filepath);

        // Loop until we reach the end of the file.
        while (!$file->eof()) {
            // Echo one line from the file.
            $arrContent[$count] = $file->fgets();
            $count++;
        }
        return $arrContent;
    }

    /**
     * File should be
     *      first line
     *      second line 
     *      ...
     */
    public static function writeArrayToFile($array, $filepath)
    {
        $firstLine = file_put_contents($filepath, $array[0] . PHP_EOL);
        $count = 0;
        for ($i = 1; $i < count($array); $i++) {
            if (file_put_contents($filepath, $array[$i] . PHP_EOL, FILE_APPEND)) {
                $count++;
            }
        }
        return $firstLine && $count;
    }

    /**
     * file should be
     *      3
     *      first line
     *      second line
     *      third line
     */
    public static function writeArrayToFileWithCountLine($array, $filepath, $firstLineContent = null)
    {
        if (!empty($firstLineContent)) {
            $firstLine = file_put_contents($filepath, $firstLineContent . PHP_EOL);
            $count = 0;
            for ($i = 0; $i < count($array); $i++) {
                if (file_put_contents($filepath, $array[$i] . PHP_EOL, FILE_APPEND)) {
                    $count++;
                }
            }
            return $firstLine && $count;
        } else {
            $firstLine = file_put_contents($filepath, count($array[0]) . PHP_EOL);
            $count = 0;
            for ($i = 0; $i < count($array); $i++) {
                if (file_put_contents($filepath, $array[$i] . PHP_EOL, FILE_APPEND)) {
                    $count++;
                }
            }
            return $firstLine && $count;
        }
    }
}
