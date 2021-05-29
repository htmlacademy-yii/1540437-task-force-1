<?php
namespace frontend\controllers;

use yii\filters\AccessControl;

class LandingController extends SecureController
{
    public $layout = 'landing';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'][] = [
            'actions' => ['index'],
            'allow' => true,
            'roles' => [ '?' ]
        ];

        // $rules['rules'][] = [
        //         'actions' => ['index'],
        //         'allow' => true,
        //         'roles' => [ '?' ]

        // ];

        // array_unshift($behaviors['access']['rules'], $rules);

        return $behaviors;

    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}