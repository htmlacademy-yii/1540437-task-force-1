<?php

namespace common\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

class Dropzone extends \yii\base\Widget
{
    // public $id = 'file_upload';

    /** @var \yii\base\Model $model */
    public $modelClass;
    /** @var string $attribute Attribute name */
    public $attribute;

    public $action;
    public $actionMessage = 'Добавить новый файл';

    /** @var array */
    public $targetOptions = [
        'class' => 'create__file'
    ];

    private $model;

    private $_target;
    private $_tag;

    public function init()
    {
        $this->_tag = ArrayHelper::remove($this->targetOptions, 'tag', 'div');
        $this->_target = "#" . $this->getId();
        $this->model = new $this->modelClass();

        $this->registerAssets();
    }

    public function run()
    {
        $this->registerJs();

        $this->targetOptions['id'] = $this->getId();
        echo Html::tag($this->_tag, "<span>{$this->actionMessage}</span>", $this->targetOptions);
    }

    private function registerAssets()
    {
        \frontend\assets\DropzoneAsset::register($this->getView());
    }

    private function registerJs()
    {

        $target = $this->getTarget();

        $dropzoneOptions = Json::encode([
            'url' => isset($this->action) ? Url::toRoute($this->action) : \Yii::$app->request->url,
            'paramName' => Html::getInputName($this->model, $this->attribute)
        ]);

        $js = <<<JS
            var dropzone_{$this->id} = new Dropzone('$target', $dropzoneOptions);
        JS;

        $this->getView()->registerJs($js, \yii\web\View::POS_READY);
    }

    private function getTarget(): string
    {
        return $this->_tag . $this->_target;
    }
}
