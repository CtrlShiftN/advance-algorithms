<?php

namespace app\controllers;

use app\models\libraries\CharacterHelper;
use app\models\libraries\Combination;
use app\models\libraries\FileHelper;
use app\models\libraries\GrayBinConvertHelper;
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
        $numberOfProcessLine = intval(trim($arrInput[0]));
        // count output combinations
        $countOutputCombinations = 0;
        for ($i = 1; $i <= $numberOfProcessLine; $i++) {
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
        $numberOfProcessLine = intval(trim($arrInput[0]));
        // count output combinations
        $countOutputCombinations = 0;
        for ($i = 1; $i <= $numberOfProcessLine; $i++) {
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
        $numberOfProcessLine = intval(trim($arrInput[0]));
        // combination elements 
        $arrCombinationElement = ['A', 'B'];
        for ($i = 1; $i <= $numberOfProcessLine; $i++) {
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
        $numberOfProcessLine = intval(trim($arrInput[0]));
        for ($i = 1; $i <= $numberOfProcessLine; $i++) {
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
        $numberOfProcessLine = intval(trim($arrInput[0]));
        for ($i = 1; $i <= $numberOfProcessLine; $i++) {
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
        $numberOfProcessLine = intval(trim($arrInput[0]));
        for ($i = 1; $i <= $numberOfProcessLine; $i++) {
            // int that needs to be split
            $currentInt = intval(trim($arrInput[$i]));
            $arrOutput[$i] = implode(" ", NumberHelper::genAllSumFactors($currentInt));
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
    public function actionEx8()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex8/');
        $inputPath = $fileDir . 'ex8.in';
        $outputPath = $fileDir . 'ex8.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        // first line in file is the number of combinations
        $numberOfProcessLine = intval(trim($arrInput[0]));
        for ($i = 1; $i <= $numberOfProcessLine; $i++) {
            // length
            $k = intval(trim($arrInput[$i]));
            $arrOutput[$i] = implode(" ", array_reverse(Permutation::genAllDiffPermutation($k)));
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
    public function actionEx9()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex9/');
        $inputPath = $fileDir . 'ex9.in';
        $outputPath = $fileDir . 'ex9.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        // first line in file is the number of combinations
        $numberOfProcessLine = intval(trim($arrInput[0]));
        for ($i = 1; $i <= $numberOfProcessLine; $i++) {
            // get length of Gray arr to gen
            $length = intval(trim($arrInput[$i]));
            // gen all fray number
            $arrOutput[$i] = implode(" ", NumberHelper::genGrayBin($length));
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
    public function actionEx10()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex10/');
        $inputPath = $fileDir . 'ex10.in';
        $outputPath = $fileDir . 'ex10.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        // first line in file is the number of combinations
        $numberOfProcessLine = intval(trim($arrInput[0]));
        for ($i = 1; $i <= $numberOfProcessLine; $i++) {
            // get length of Gray arr to gen
            $binaryNumber = trim($arrInput[$i]);
            // gen all fray number
            $arrOutput[$i] = GrayBinConvertHelper::binarytoGray($binaryNumber);
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
    public function actionEx11()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex11/');
        $inputPath = $fileDir . 'ex11.in';
        $outputPath = $fileDir . 'ex11.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        // first line in file is the number of combinations
        $numberOfProcessLine = intval(trim($arrInput[0]));
        for ($i = 1; $i <= $numberOfProcessLine; $i++) {
            // get length of Gray arr to gen
            $grayNumber = trim($arrInput[$i]);
            // gen all fray number
            $arrOutput[$i] = GrayBinConvertHelper::graytoBinary($grayNumber);
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

    public function actionEx12()
    {
        $fileDir = './' . Url::to('/uploads/generation/ex12/');
        $inputPath = $fileDir . 'ex12.in';
        $outputPath = $fileDir . 'ex12.out';
        $arrInput = FileHelper::readFileByLineAsArray($inputPath);
        $arrOutput = [];
        // first line in file is binary length and occurrence
        $arrLengthAndOccurrence = array_map('intval', explode(" ", trim($arrInput[0])));
        $arrSpecialAB = CharacterHelper::getSpecialAB($arrLengthAndOccurrence[0], $arrLengthAndOccurrence[1]);
        $arrOutput[] = implode(" ", $arrSpecialAB);
        // write to file
        FileHelper::writeArrayToFileWithCountLine(array_values($arrOutput), $outputPath, strval(count($arrSpecialAB)));
        // render to view
        return $this->render('ex1', [
            'title' => Yii::$app->controller->action->id,
            'arrInput' => $arrInput,
            'arrOutput' => FileHelper::readFileByLineAsArray($outputPath),
            'inputPath' => $inputPath,
            'outputPath' => $outputPath
        ]);
    }
}
