<?php
namespace frontend\controllers;

use Tasks;

class TasksController extends FrontendController
{
    public function actionIndex()
    {
        $models = \frontend\models\Tasks::find()
            ->with(['category', 'city'])
            ->avaiable()
            ->orderBy("created_at DESC")
            ->all();

        return $this->render('index', [
            'models' => $models
        ]);
    }
}

