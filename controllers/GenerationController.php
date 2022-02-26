<?php

namespace app\controllers;

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
}
