<?php

namespace frontend\models\forms;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * 
 * @property UploadedFile[]|UploadedFile $file
 * @property int $task ID здаания, для которого загружется фаил
 * @property int $user ID пользоватенля что загружет фаил
 */
class FileUploadForm extends \yii\base\Model
{

    /** @var UploadedFile[]|UploadedFile|null File attribute */
    public $file;

    public $task;    
    private $_userId;

    private $filePathTemplate = "{basePath}/uploads/{task_id}";

    /** @var string */
    private $_folderPath;
    

    public function rules()
    {
        return [
            ['file', 'file'],
            [['task', 'user'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Фаил',
            'user' => 'Пользователь',
            'task' => 'Задание'
        ];
    }

    /**
     * Идентификатор пользователя
     * 
     * @return null|int 
     */
    public function getUser(): ?int
    {
        if (!$this->_userId) {
            $this->_userId = \Yii::$app->user->id;
        }

        return $this->_userId;
    }

    Public function setUser($value)
    {
        $this->_userId = $value;
    }

    public function upload(): bool
    {
     
        $folderPath = $this->getFolderPath(true);

        if (is_array($this->file)) {
            foreach ($this->file as $file) {
                if ($file->saveAs($folderPath . DIRECTORY_SEPARATOR . $file->name)) {
                    return $this->saveInDb($file);
                }
            }
        } else {
            $file = $this->file;
            if ($file->saveAs($folderPath . DIRECTORY_SEPARATOR . $file->name)) {
                return $this->saveInDb($file);
            }
        }        
    
    }

    private function saveInDb(UploadedFile $file)
    {
        $fileName = $this->generateRandomFileName(8);

        if ($file->extension) {
            $fileName = $fileName . "." . $file->extension;
        }

        $model = new \frontend\models\UserAttachment();
        $model->task_id = $this->task;
        $model->user_id = $this->getUser();
        $model->display_name = $file->name;
        $model->file_name = $fileName;
        $model->file_path = $this->getFolderPath(false);
        $model->file_meta = FileHelper::getMimeType($this->getFolderPath(true). DIRECTORY_SEPARATOR . $file->name);
        return $model->save();
    }

    /**
     * 
     * @param bool $absolute 
     * @return string|null 
     */
    public function getFolderPath(bool $absolute = true)
    {
        if (!$this->_folderPath) {
            $this->_folderPath = strtr($this->filePathTemplate, [
                '{task_id}' => "task_attachments" . DIRECTORY_SEPARATOR . $this->task,
                '{basePath}' => "@webroot"
            ]);

            $this->createFolder(Yii::getAlias($this->_folderPath));
        }

        return  $absolute ? Yii::getAlias($this->_folderPath) : $this->_folderPath ;
        
    }

    private function createFolder(string $path): bool
    {
        return FileHelper::createDirectory($path) ? 
            true  :
            false ;
    }

    public function generateRandomFileName(int $length = 16)
    {
        $string = Yii::$app->security->generateRandomString($length);
        return strtolower(trim(str_replace(['_','-'], '', $string)));
    }
}
