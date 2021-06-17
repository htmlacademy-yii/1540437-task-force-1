<?php

namespace common\widgets;

class ActiveField extends \yii\widgets\ActiveField
{
    public $options = [
        'class' => null,
        'style' => 'display: flex; flex-direction: column; padding-bottom: 10px;'
    ];

    public $template = "{label}\n{input}\n{hint}\n{error}";
    public $inputOptions = [
        'class' => 'input textarea',
        'rows' => 1,
    ];
    public $errorOptions = [
        'class' => null,
        'tag' => 'span'
    ];
    public $labelOptions = ['class' => null];
    public $hintOptions = ['class' => 'help-text', 'tag' => 'span'];
}
