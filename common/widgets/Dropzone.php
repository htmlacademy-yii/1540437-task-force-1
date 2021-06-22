<?php

namespace common\widgets;

use frontend\models\forms\FileUploadForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class Dropzone extends \yii\base\Widget
{
    public $action = ['file/ajax-upload'];
    public $task = null;
    public $user = null;

    public $actionMessage = 'Добавить новый файл';

    /** @var array */
    public $targetOptions = [
        'class' => 'create__file'
    ];

    private $_mainId;
    private $_model;
    private $_tag;

    public function init()
    {
        $this->_mainId = $this->getId();
        $this->_model = self::model();
        $this->_tag = ArrayHelper::remove($this->targetOptions, 'tag', 'div');

        $this->registerAssets();
        $this->registerJs();
    }

    /**
     * @see https://www.dropzonejs.com/#layout
     */
    private function showTemplate()
    {
        /** TODO: реализовать собственный шаблон, если потребутеся */
        return null;
    }

    public function run()
    {

        $this->targetOptions['id'] = $this->getId();

        echo Html::activeLabel($this->_model, 'file');
        echo Html::activeHint($this->_model, 'file', ['tag' => 'span', 'class' => null]);
        echo Html::tag($this->_tag, "<span>{$this->actionMessage}</span>", $this->targetOptions);
    }

    private function registerAssets()
    {
        \frontend\assets\DropzoneAsset::register($this->getView());
    }

    private function registerJs()
    {

        $userFieldName = Html::getInputName($this->_model, 'user');
        $taskFieldName = Html::getInputName($this->_model, 'task');
        $fileFieldName = Html::getInputName($this->_model, 'file');

        $csrfParam = \Yii::$app->request->csrfParam;
        $csrfValue = \Yii::$app->request->csrfToken;


        $id = \lcfirst(\yii\helpers\Inflector::camelize($this->_mainId));

        $js = <<<JS
            Dropzone.autoDiscover = false;

            var dropzone_$id = new Dropzone('#{$this->_mainId}', {
                url: "{$this->action()}",
                paramName: "{$fileFieldName}"                
            });

            dropzone_$id.on('sending', function(file, xhr, formData) {
                formData.append('{$csrfParam}', '{$csrfValue}');
                formData.append('{$userFieldName}', '{$this->user}');
                formData.append('{$taskFieldName}', '{$this->task}');
            })
        JS;

        $this->getView()->registerJs($js, \yii\web\View::POS_READY);
    }

    public static function model()
    {
        return new FileUploadForm();
    }

    private function action()
    {
        return isset($this->action) ? Url::toRoute($this->action) : \Yii::$app->request->url;
    }
}
