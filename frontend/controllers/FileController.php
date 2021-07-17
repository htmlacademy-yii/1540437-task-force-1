<?php

namespace frontend\controllers;

use frontend\models\UserAttachment;
use Yii;

use yii\web\UploadedFile;

class FileController extends FrontendController
{

    public function actionAjaxUpload()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = \common\widgets\Dropzone::model();

        $model->load(Yii::$app->request->post());
        $model->file = UploadedFile::getInstance($model, 'file');

        if ($model->validate() && $model->upload()) {
            return 'OK';
        } else {
            return [
                'success' => 'false',
                'message' => $model->getErrors()
            ];
        }
    }

    public function actionView(string $path)
    {
    }
}
