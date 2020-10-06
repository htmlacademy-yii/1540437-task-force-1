<?php

namespace frontend\controllers;

use frontend\models\search\UserSearch;
use Yii;
use yii\data\Sort;

class UsersController extends FrontendController
{
    /** @var int Ограничения на колво записей */
    const PAGE_LIMIT = 5;

    public function actionIndex($params = null)
    {
        $session = Yii::$app->getSession();

        $sort = new Sort();
 
        $searchModel  = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sort' => $sort
        ]);

        // $query = User::find()
        //     ->select([
        //         'users.*',
        //         'avgRating' => 'avg(tr.evaluation)',
        //         'countResponses' => 'count(`tr`.`id`)'
        //     ])
        //     ->with(['categories', 'performerTasks'])
        //     ->joinWith(['taskResponses tr'])
        //     ->groupBy(['users' => 'id', 'tr' => 'user_id'])
        //     ->orderBy(['avgRating' => SORT_DESC])
        //     ->performers();

        // $countQuery = clone $query;
        // $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => self::PAGE_LIMIT]);
        // $query->offset($pages->offset)->limit($pages->limit);

        // return $this->render('index', [
        //     'models' => $query->all(),
        //     'pages' => $pages,
        //     'categoryFilterForm' => $categoryForm
        // ]);
    }
}
