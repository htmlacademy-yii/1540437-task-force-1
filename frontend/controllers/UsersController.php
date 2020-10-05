<?php

namespace frontend\controllers;

use frontend\models\forms\CategoryFilterForm;
use frontend\models\User;
use Yii;
use yii\data\Pagination;

class UsersController extends FrontendController
{
    /** @var int Ограничения на колво записей */
    const PAGE_LIMIT = 5;

    public function actionIndex()
    {
        $categoryForm = new CategoryFilterForm();

        if (Yii::$app->request->isPost) {
            $categoryForm->load(Yii::$app->request->post());
        }

        $query = User::find()
            ->select([
                'users.*',
                'avgRating' => 'avg(tr.evaluation)',
                'countResponses' => 'count(`tr`.`id`)'
            ])
            ->with(['categories', 'performerTasks'])
            ->joinWith(['taskResponses tr'])
            ->groupBy(['users' => 'id', 'tr' => 'user_id'])
            ->orderBy(['avgRating' => SORT_DESC])
<<<<<<< HEAD
            ->performers()->limit(\Yii::$app->params['pagination.perPage'])->all();

        return $this->render('index', [
            'models' => $models
=======
            ->performers();

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => self::PAGE_LIMIT]);
        $query->offset($pages->offset)->limit($pages->limit);


        return $this->render('index', [
            'models' => $query->all(),
            'pages' => $pages,
            'categoryFilterForm' => $categoryForm
>>>>>>> 3bd84bf7b0f177b8b24981b055b0376d4831b0b3
        ]);
    }
}
