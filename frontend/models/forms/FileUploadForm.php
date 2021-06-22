<?php

namespace frontend\models\forms;

use yii\web\UploadedFile;

class FileUploadForm extends \yii\base\Model
{

    /** @var UploadedFile|null File attribute */
    public $file;
    public $task;
    public $user;

    public function rules()
    {
        return [
            [['file'], 'required'],
            [['task', 'user'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Фаил'
        ];
    }

    public function upload()
    {
        return true;
    }
}
