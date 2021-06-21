<?php

namespace frontend\controllers;

use frontend\models\search\PerformerSearch;
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
        $searchModel  = new PerformerSearch();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id): string
    {
        $model = $this->loadModel($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionPerformer()
    {
        $searchModel = new PerformerSearch();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->post());

        return $this->render('performer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Загрузка модели
     *
     * @param string $id
     * @return User
     * 
     * @throws NotFoundHttpException
     */
    private function loadModel(string $id)
    {
        // $model = User::find()->with([
        //     'profile',
        //     'taskResponses' => function ($q) {
        //         return $q->with(['task', 'user']);
        //     }
        // ])
        //     ->where(['id' => $id])
        //     ->one();

        $model = User::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $model;
    }
}
