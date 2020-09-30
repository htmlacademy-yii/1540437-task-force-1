<?php

namespace frontend\controllers;

use frontend\models\Users;

class UsersController extends FrontendController
{
    public function actionIndex()
    {
        $models = Users::find()
            ->performers()
            ->with(['categories', 'performerTasks', 'taskResponsesAggregation'])
            ->all();

        return $this->render('index', [
            'models' => $models
        ]);
    }
}
