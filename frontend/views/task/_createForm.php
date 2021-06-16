<?php

use common\models\Category;
use common\widgets\ActiveForm;
use frontend\models\forms\FileUploadForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var \frontend\models\forms\TaskForm $model */

?>

<?php $form = ActiveForm::begin([
    'id' => 'create-task-form',
    'enableClientValidation' => false,
    'validationUrl' => ['task/ajax-validate'],
    'enableAjaxValidation' => true,
    'options' => [
        'enctype' => "multipart/form-data",
        'class' => 'create__task-form form-create',
    ],
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{hint}"
    ]
]); ?>

<?= $form->field($model, 'title')->input('text', ['placeholder' => 'Повесить полку']); ?>
<?= $form->field($model, 'description')->textarea(['placeholder' => 'Ваше сообщение', 'rows' => 7]); ?>
<?= $form->field($model, 'category')->dropDownList(
    ArrayHelper::merge(['' => 'Выберите категорию...'], ArrayHelper::map(Category::find()->all(), 'id', 'name')),
    [
        'class' => 'multiple-select input multiple-select-big',
        'options' => [
            '' => [
                'selected' => true,
                'disabled' => true
            ]
        ]
    ]
); ?>

<div class="field-taskform-files" style="display: flex; flex-direction: column; padding-bottom: 10px;">
    <?= Html::activeLabel($model, 'files'); ?>
    <?= Html::activeHint($model, 'files', ['tag' => 'span', 'class' => null]); ?>

    <?= \common\widgets\Dropzone::widget([
        'action' => ['task/ajax-upload'],
        'modelClass' => FileUploadForm::class,
        'attribute' => 'file[]'
    ]); ?>

</div>

<?= $form->field($model, 'location')->textInput(['class' => 'input-navigation input-middle input']); ?>

<div class="create__price-time">
    <?= $form->field($model, 'budget', ['options' => ['class' => 'create__price-time--wrapper']])->textarea(['class' => 'input textarea input-money']); ?>
    <?= $form->field($model, 'expire', ['options' => ['class' => 'create__price-time--wrapper']])->input('date', ['class' => 'input-middle input input-date']); ?>
</div>

<?php $this->beginBlock('task-form-submit-button'); ?>
<?= Html::submitButton('Опубликовать', ['form' => $form->id, 'class' => 'button']); ?>
<?php $this->endBlock(); ?>

<?php ActiveForm::end(); ?>