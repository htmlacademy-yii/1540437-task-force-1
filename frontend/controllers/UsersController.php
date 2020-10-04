<?php

namespace frontend\controllers;

use frontend\models\User;

class UsersController extends FrontendController
{
    /** @var int Ограничения на колво записей */
    const PAGE_LIMIT = 15;

    public function actionIndex()
    {
        $models = User::find()
            ->select([
                'users.*',
                'avgRating' => 'avg(tr.evaluation)',
                'countResponses' => 'count(`tr`.`id`)'
            ])
            ->with(['categories', 'performerTasks'])
            ->joinWith(['taskResponses tr'])
            ->groupBy(['users' => 'id', 'tr' => 'user_id'])
            ->orderBy(['avgRating' => SORT_DESC])
            ->performers()
            ->limit(self::PAGE_LIMIT)->all();

        return $this->render('index', [
            'models' => $models
        ]);
    }
}
