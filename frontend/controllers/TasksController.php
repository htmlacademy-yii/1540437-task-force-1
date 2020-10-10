<?php

namespace frontend\controllers;

use frontend\models\Task;

class TasksController extends FrontendController
{
    /** @var int Ограничения на колво записей */
    const PAGE_SIZE = 15;

    public function actionIndex()
    {
        $models = Task::find()
            ->with(['category', 'city'])
            ->new()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(self::PAGE_SIZE)
            ->all();

        return $this->render('index', [
            'models' => $models
        ]);
    }
}
