<?php

namespace frontend\controllers;

use frontend\models\search\TaskSearch;
use frontend\models\Task;
use frontend\models\TaskResponses;
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
        

        // $model = Task::find()
        //     ->with([
        //         'taskChats',
        //         'taskResponses.user' => function ($q) {
        //             return $q->with(['ratingAgregation', 'profile']);
        //         },
        //         'category',
        //         'ticketAttachments'
        //     ])
        //     ->where(['id' => $id])
        //     ->one();

        // if ($model === null) {
        //     throw new NotFoundHttpException('Запрашиваемая страница не найдена');
        // }

        return $this->render('view', [
            'model' => $model, // $model
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
