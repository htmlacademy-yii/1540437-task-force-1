<?php

namespace frontend\controllers;

use frontend\models\forms\FileUploadForm;
use yii\web\UploadedFile;

class FileController extends FrontendController
{
    public function actionUpload()
    {
        $model = new FileUploadForm();
        $model->file = UploadedFile::getInstances($model, 'file');

    }

    public function actionAjaxUpload()
    {
        $model = new FileUploadForm();
        $model->file = UploadedFile::getInstances($model, 'file');
        
    }

    public function actionView(string $path)
    {
    }
}
