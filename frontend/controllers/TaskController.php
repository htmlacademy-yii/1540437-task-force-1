<?php

namespace frontend\controllers;

use frontend\models\search\TaskSearch;
use yii\web\NotFoundHttpException;
use Yii;

class TaskController extends FrontendController
{
    /** @var int Ограничения на колво записей */
    const PAGE_SIZE = 5;

    /** {@inheritDoc} */
    public function actionIndex()
    {
        $searchModel  = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /** {@inheritDoc} */
    public function actionView($id): string
    {

        $model = $this->loadModel($id);

        return $this->render('view', [
            'model' => $model, // $model
        ]);
    }

    public function actionCreate()
    {

        if (\Yii::$app->user->role !== \app\bizzlogic\User::ROLE_CUSTOMER) {
        }

        $model = new \frontend\models\forms\TaskForm();

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Загрузка модели по ее ID
     *
     * @param string $id
     * @return frontend\models\Task
     */
    private function loadModel(string $id): \frontend\models\Task
    {
        $model = \frontend\models\Task::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $model;
    }
}
