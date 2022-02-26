<?php

namespace app\models\libraries;

use SplFileObject;

class FileHelper
{
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

    public static function writeArrayToFile($array, $filepath)
    {
        $firstLine = file_put_contents($filepath, $array[0]);
        $count = 0;
        for ($i = 1; $i < count($array); $i++) {
            if (file_put_contents($filepath, $array[$i], FILE_APPEND)) {
                $count++;
            }
        }
        return $firstLine && $count;
    }
}
