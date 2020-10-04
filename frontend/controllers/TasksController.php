<?php

namespace frontend\controllers;

use frontend\models\Task;

class TasksController extends FrontendController
{
    /** @var int Ограничения на колво записей */
    const PAGE_LIMIT = 15;

    public function actionIndex()
    {
        $models = Task::find()
            ->with(['category', 'city'])
            ->avaiable()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(self::PAGE_LIMIT)
            ->all();

        return $this->render('index', [
            'models' => $models
        ]);
    }
}
