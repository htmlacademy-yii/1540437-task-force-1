<?php

namespace frontend\controllers;

use frontend\models\search\TaskSearch;
use frontend\models\Task;
use yii\web\NotFoundHttpException;

class TaskController extends FrontendController
{
    /** @var int Ограничения на колво записей */
    const PAGE_SIZE = 5;

    /** {@inheritDoc} */
    public function actionIndex()
    {
        $searchModel  = new TaskSearch();
        $dataProvider = $searchModel->search(\Yii::$app->getRequest()->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /** {@inheritDoc} */
    public function actionView($id): string
    {

        $model = Task::find()->with(['taskChats', 'taskResponses', 'category', 'ticketAttachments'])->where(['id' => $id])->one();

        if ($model === null) {
            throw new NotFoundHttpException('Запрашиваемая страница не найдена');
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }
}
