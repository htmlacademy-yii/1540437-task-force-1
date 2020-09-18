<?php
namespace frontend\controllers;

use common\models\Tasks;

class TasksController extends FrontendController
{
    public function actionIndex()
    {
        $models = Tasks::find()->all();

        return $this->render('index', [
            'models' => $models
        ]);
    }
}

