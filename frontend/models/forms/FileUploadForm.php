<?php

namespace frontend\models\forms;

use yii\web\UploadedFile;

class FileUploadForm extends \yii\base\Model
{

    /** @var UploadedFile|null File attribute */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'required']
        ];
    }

    public function upload()
    {
    }
}
