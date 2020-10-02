<?php

namespace frontend\controllers;

use frontend\models\Tasks;

class TasksController extends FrontendController
{
    public function actionIndex()
    {
        $models = Tasks::find()
            ->with(['category', 'city'])
            ->avaiable()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(\Yii::$app->params['pagination.perPage'])
            ->all();

        return $this->render('index', [
            'models' => $models
        ]);
    }
}
