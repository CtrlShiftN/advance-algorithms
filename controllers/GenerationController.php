<?php

namespace app\controllers;

use app\models\libraries\Combination;
use app\models\libraries\FileHelper;
use app\models\libraries\NumberHelper;
use app\models\libraries\Permutation;
use Yii;
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
            'title' => Yii::$app->controller->action->id,
            'arrInput' => $arrInput,
            'arrOutput' => $arrOutput,
            'inputPath' => $inputPath,
            'outputPath' => $outputPath
        ]);
    }

    /**
     * 
     */
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
            // convert String array into int array
            $kAndNArray = array_map('intval', $kAndNArray);
            $currentCombine = array_map('intval', $currentCombine);
            // find next combination
            $arrOutput[$countOutputCombinations] = Combination::findNextCombination($kAndNArray[1], $kAndNArray[0], $currentCombine);
            // implode all numbers into a number
            $arrOutput[$countOutputCombinations] = implode($arrOutput[$countOutputCombinations]);
            // raise count
            $countOutputCombinations++;
        }
        // write to file
        FileHelper::writeArrayToFile($arrOutput, $outputPath);
        // render to view
        return $this->render('ex1', [
            'title' => Yii::$app->controller->action->id,
            'arrInput' => $arrInput,
            'arrOutput' => $arrOutput,
            'inputPath' => $inputPath,
            'outputPath' => $outputPath
        ]);
    }

    public function actionEx3()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex3/');
        $inputPath = $fileDir . 'ex3.in';
        $outputPath = $fileDir . 'ex3.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        // first line in file is the number of combinations
        $numberOfPermutation = intval(trim($arrInput[0]));
        // count output combinations
        $countOutputCombinations = 0;
        for ($i = 1; $i <= $numberOfPermutation; $i++) {
            // current combination on the next line of $k an $n
            $currentPermutation = array_map('intval', explode(" ", trim($arrInput[$i * 2])));
            // find next combination
            $arrOutput[$countOutputCombinations] = Permutation::genNextPermutationFromArray($currentPermutation);
            // implode all numbers into a number
            $arrOutput[$countOutputCombinations] = implode($arrOutput[$countOutputCombinations]);
            // raise count
            $countOutputCombinations++;
        }
        // write to file
        FileHelper::writeArrayToFile($arrOutput, $outputPath);
        // render to view
        return $this->render('ex1', [
            'title' => Yii::$app->controller->action->id,
            'arrInput' => $arrInput,
            'arrOutput' => $arrOutput,
            'inputPath' => $inputPath,
            'outputPath' => $outputPath
        ]);
    }

    public function actionEx4()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex4/');
        $inputPath = $fileDir . 'ex4.in';
        $outputPath = $fileDir . 'ex4.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        // first line in file is the number of combinations
        $numberOfCombination = intval(trim($arrInput[0]));
        // combination elements 
        $arrCombinationElement = ['A', 'B'];
        for ($i = 1; $i <= $numberOfCombination; $i++) {
            // combination length
            $combinationLength = intval(trim($arrInput[$i]));
            $arrOutput[$i] = implode(" ", Combination::generateAllCombination($arrCombinationElement, $combinationLength));
        }
        // write to file
        FileHelper::writeArrayToFile(array_values($arrOutput), $outputPath);
        // render to view
        return $this->render('ex1', [
            'title' => Yii::$app->controller->action->id,
            'arrInput' => $arrInput,
            'arrOutput' => $arrOutput,
            'inputPath' => $inputPath,
            'outputPath' => $outputPath
        ]);
    }
    public function actionEx5()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex5/');
        $inputPath = $fileDir . 'ex5.in';
        $outputPath = $fileDir . 'ex5.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        // first line in file is the number of combinations
        $numberOfCombination = intval(trim($arrInput[0]));
        for ($i = 1; $i <= $numberOfCombination; $i++) {
            // combination $k and $n
            $kAndNCombination = array_map('intval', explode(" ", trim($arrInput[$i])));
            $arrOutput[$i] = implode(" ", Combination::genDiffCombination($kAndNCombination[1], $kAndNCombination[0]));
        }
        // write to file
        FileHelper::writeArrayToFile(array_values($arrOutput), $outputPath);
        // render to view
        return $this->render('ex1', [
            'title' => Yii::$app->controller->action->id,
            'arrInput' => $arrInput,
            'arrOutput' => $arrOutput,
            'inputPath' => $inputPath,
            'outputPath' => $outputPath
        ]);
    }
    public function actionEx6()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex6/');
        $inputPath = $fileDir . 'ex6.in';
        $outputPath = $fileDir . 'ex6.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        // first line in file is the number of combinations
        $numberOfPermutation = intval(trim($arrInput[0]));
        for ($i = 1; $i <= $numberOfPermutation; $i++) {
            // length
            $k = intval(trim($arrInput[$i]));
            $arrOutput[$i] = implode(" ", Permutation::genAllDiffPermutation($k));
        }
        // write to file
        FileHelper::writeArrayToFile(array_values($arrOutput), $outputPath);
        // render to view
        return $this->render('ex1', [
            'title' => Yii::$app->controller->action->id,
            'arrInput' => $arrInput,
            'arrOutput' => $arrOutput,
            'inputPath' => $inputPath,
            'outputPath' => $outputPath
        ]);
    }
    public function actionEx7()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex7/');
        $inputPath = $fileDir . 'ex7.in';
        $outputPath = $fileDir . 'ex7.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        // first line in file is the number of combinations
        $numberOfPermutation = intval(trim($arrInput[0]));
        print_r(NumberHelper::genAllSumFactors(4));die;
        for ($i = 1; $i <= $numberOfPermutation; $i++) {

        }
        // write to file
        // FileHelper::writeArrayToFile(array_values($arrOutput), $outputPath);
        // render to view
        return $this->render('ex1', [
            'title' => Yii::$app->controller->action->id,
            'arrInput' => $arrInput,
            'arrOutput' => $arrOutput,
            'inputPath' => $inputPath,
            'outputPath' => $outputPath
        ]);
    }
}
