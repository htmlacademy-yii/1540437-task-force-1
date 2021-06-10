<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \frontend\models\forms\TaskForm $model */

?>

<?php $form = ActiveForm::begin([
    'id' => 'create-task-form',
    'options' => [
        'csrf' => false,
        'class' => 'registration__user-form form-create'
    ],
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{hint}",
        'hintOptions' => ['tag' => 'span'],
        'options' => [
            'style' => 'display: flex; flex-direction: column; padding-bottom: 10px;'
        ],
        'inputOptions' => [
            'class' => 'input textarea',
            'rows' => 1,
        ],
        'labelOptions' => [
            'class' => false
        ]
    ]
]); ?>

<?= $form->field($model, 'title'); ?>
<?= $form->field($model, 'description'); ?>
<?= $form->field($model, 'category'); ?>
<?= $form->field($model, 'files'); ?>
<?= $form->field($model, 'location'); ?>
<?= $form->field($model, 'budget'); ?>
<?= $form->field($model, 'expire'); ?>

<?php ActiveForm::end(); ?>