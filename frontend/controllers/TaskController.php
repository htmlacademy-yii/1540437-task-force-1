<?php

namespace frontend\controllers;

use frontend\models\forms\TaskForm;
use frontend\models\search\TaskSearch;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\UploadedFile;

class TaskController extends FrontendController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['create'],
            'matchCallback' => function ($rule, $action) {
                /** @var \yii\base\InlineAction $action */
                /** @var  \yii\filters\AccessRule $rule */
                return Yii::$app->user->role !== \app\bizzlogic\User::ROLE_CUSTOMER;
            }
        ];

        \array_unshift($behaviors['access']['rules'], $rule);

        return $behaviors;
    }

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

    public function actionAjaxValidate()
    {
        $model = new \frontend\models\forms\TaskForm();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model->saveDraft();
        return \common\widgets\ActiveForm::validate($model);
    }

    /**
     * Опубликовать задание
     * 
     * @param mixed $id Идентификатор задания
     */
    public function actionPublish($id)
    {
        $model = $this->loadModel($id);
        $model->published_at = new \yii\db\Expression('NOW()');
        if ($model->save()) {
            $this->redirect(['task/view', 'id' => $id]);
        }
    }

    public function actionCreate()
    {
        $form = new TaskForm();
        $form->loadDraft();

        if (Yii::$app->request->getIsPost()) {
            $form->load(Yii::$app->request->post());
            $form->saveDraft();
            $form->validate();

            if (Yii::$app->getRequest()->getIsPjax()) {
                return $this->renderPartial('_createForm', ['model' => $form]);
            }
        }



        return $this->render('create', ['model' => $form]);
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

    public function beforeAction($action)
    {
        /** @var \yii\base\InlineAction $action */
        if ($action->id === 'ajax-upload') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
}
