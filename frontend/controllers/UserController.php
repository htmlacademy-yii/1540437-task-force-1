<?php

namespace frontend\controllers;

use frontend\models\search\UserSearch;
use frontend\models\User;
use Yii;
use yii\web\NotFoundHttpException;

class UserController extends FrontendController
{
    /** @var int Ограничения на колво записей */
    const PAGE_SIZE = 5;

    public function actionIndex()
    {
        $searchModel  = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id): string
    {
        $model = User::findOne($id);

        // if ($model === null || $model->isPerformer === false) {
        //     throw new NotFoundHttpException('Пользователь не найден');
        // }

        return $this->render('view', [
            'model' => $model
        ]);
    }
}
