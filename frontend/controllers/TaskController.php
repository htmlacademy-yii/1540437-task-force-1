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

    public function actionAjaxUpload()
    {

        if (!Yii::$app->request->isAjax) {
            Yii::$app->response->statusCode = '500';
            return [];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $uploadForm = new \frontend\models\forms\FileUploadForm();
        $uploadForm->file = UploadedFile::getInstances($uploadForm, 'file');

        if ($uploadForm->file && $uploadForm->validate()) {
            return [
                'success' => true,
                'files' => $uploadForm->file,
            ];
        } else {
            return [
                'success' => false,
                'errors' => $uploadForm->getErrors('file')
            ];
        }
    }

    public function actionAjaxValidate()
    {
        $model = new \frontend\models\forms\TaskForm();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // return [
        //     'validate' => \common\widgets\ActiveForm::validate($model),
        //     'data' => $this->renderAjax('_create-warnings', ['model' => $model])
        // ];
        return \common\widgets\ActiveForm::validate($model);
    }

    public function actionCreate()
    {
        $model = TaskForm::draftModel();
        // $model = new \frontend\models\forms\TaskForm();

        if (Yii::$app->request->getIsPost()) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $taskId = $model->publish();
                return $this->redirect(['task/view', 'id' => $taskId]);
            } elseif (Yii::$app->request->getIsAjax()) {
                return $this->renderAjax('_create-warnings', ['model' => $model]);
            }
        }

        return $this->render('create', ['model' => $model]);
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
