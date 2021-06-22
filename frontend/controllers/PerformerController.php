<?php

namespace frontend\controllers;

use frontend\models\Performer;
use frontend\models\search\PerformerSearch;
use Yii;
use yii\web\NotFoundHttpException;

class PerformerController extends FrontendController
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
        $query = Performer::find();
        $query->with([
            'city',
            'profile',
            'skils',
            'taskReviews' => function ($query) {
                /** @var \frontend\models\query\UserReviewQuery $query */
                $query->with(['customer', 'performer', 'task']);
            },
        ]);

        $query->andWhere(['users.id' => $id]);

        $model = $query->one();

        if ($model === null) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $model;
    }
}
