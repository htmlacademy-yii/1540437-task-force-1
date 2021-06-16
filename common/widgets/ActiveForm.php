<?php

namespace common\widgets;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $fieldClass = ActiveField::class;
    public $enableClientValidation = true;
    public $enableAjaxValidation = false;
}
