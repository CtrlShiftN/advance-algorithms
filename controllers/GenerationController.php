<?php

namespace app\controllers;

use app\models\libraries\Combination;
use app\models\libraries\FileHelper;
use app\models\libraries\NumberHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class GenerationController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = 'main';
        if (!parent::beforeAction($action)) {
            return false;
        }
        return true; // or false to not run the action
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Turn a file of binary to next of its
     * 
     *  */
    public function actionEx1()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex1/');
        $inputPath = $fileDir . 'ex1.in';
        $outputPath = $fileDir . 'ex1.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        foreach ($arrInput as $key => $value) {
            $arrOutput[$key] = NumberHelper::getNextBinaryNumber($value);
        }
        FileHelper::writeArrayToFile($arrOutput, $outputPath);
        return $this->render('ex1', [
            'arrInput' => $arrInput,
            'arrOutput' => $arrOutput,
            'inputPath' => $inputPath,
            'outputPath' => $outputPath
        ]);
    }

    public function actionEx2()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex2/');
        $inputPath = $fileDir . 'ex2.in';
        $outputPath = $fileDir . 'ex2.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        // first line in file is the number of combinations
        $numberOfCombination = intval(trim($arrInput[0]));
        // count output combinations
        $countOutputCombinations = 0;
        for ($i = 1; $i <= $numberOfCombination; $i++) {
            // $k $n to be [$k,$n]
            $kAndNArray = explode(" ", trim($arrInput[$i * 2 - 1]));
            // current combination on the next line of $k an $n
            $currentCombine = explode(" ", trim($arrInput[$i * 2]));
            $kAndNArray = array_map('intval', $kAndNArray);
            $currentCombine = array_map('intval', $currentCombine);
            $arrOutput[$countOutputCombinations] = Combination::findNextCombination($kAndNArray[1], $kAndNArray[0], $currentCombine);
            $arrOutput[$countOutputCombinations] = implode($arrOutput[$countOutputCombinations]);
            $countOutputCombinations++;
        }
        FileHelper::writeArrayToFile($arrOutput, $outputPath);
        return $this->render('ex1', [
            'arrInput' => $arrInput,
            'arrOutput' => $arrOutput,
            'inputPath' => $inputPath,
            'outputPath' => $outputPath
        ]);
    }
}
