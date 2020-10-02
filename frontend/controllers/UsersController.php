<?php

namespace frontend\controllers;

use frontend\models\Users;

class UsersController extends FrontendController
{
    public function actionIndex()
    {
        $models = Users::find()
            ->select([
                'users.*',
                'avgRating' => 'avg(tr.evaluation)',
                'countResponses' => 'count(`tr`.`id`)'
            ])
            ->with(['categories', 'performerTasks'])
            ->joinWith(['taskResponses tr'])
            ->groupBy(['users' => 'id', 'tr' => 'user_id'])
            ->orderBy(['avgRating' => SORT_DESC])
            ->performers()->limit(\Yii::$app->params['pagination.perPage'])->all();

        return $this->render('index', [
            'models' => $models
        ]);
    }
}
