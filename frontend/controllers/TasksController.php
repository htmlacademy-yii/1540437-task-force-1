<?php
namespace frontend\controllers;

use Tasks;

class TasksController extends FrontendController
{
    public function actionIndex()
    {
        $models = \frontend\models\Tasks::find()->new()->with(['category'])->limit(5)->all();

        return $this->render('index', [
            'models' => $models
        ]);
    }
}

