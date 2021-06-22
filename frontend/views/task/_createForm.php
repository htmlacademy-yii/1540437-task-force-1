<?php

use common\models\Category;
use common\widgets\ActiveForm;
use frontend\models\forms\FileUploadForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var \frontend\models\forms\TaskForm $model */

?>

<div class="create__task-form form-create">
    <?php $form = ActiveForm::begin([
        // 'id' => 'create-task-form',
        'action' => ['task/publish', 'id' => $model->getTaskId()],
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'validateOnBlur' => false,
        'validateOnChange' => true,
        'validationUrl' => ['task/ajax-validate'],
        'options' => [
            'enctype' => "multipart/form-data",
            'data-pjax' => true
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

        <?= \common\widgets\Dropzone::widget([
            'id' => 'tasks-upload',
            'user' => \Yii::$app->user->id,
            'task' => $model->taskId
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

</div>

<div class="create__warnings">
    <div class="warning-item warning-item--advice">
        <h2>Правила хорошего описания</h2>
        <h3>Подробности</h3>
        <p>Друзья, не используйте случайный<br>
            контент – ни наш, ни чей-либо еще. Заполняйте свои
            макеты, вайрфреймы, мокапы и прототипы реальным
            содержимым.</p>
        <h3>Файлы</h3>
        <p>Если загружаете фотографии объекта, то убедитесь,
            что всё в фокусе, а фото показывает объект со всех
            ракурсов.</p>
    </div>

    <?php

    if ($model->hasErrors()) : ?>
        <div class="warning-item warning-item--error">
            <h2>Ошибки заполнения формы</h2>
            <?php foreach ($model->errors as $category => $errors) : ?>
                <?= Html::tag('h3', $model->getAttributeLabel($category)); ?>
                <?php foreach ($errors as $error) : ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>
</div>

<?php ActiveForm::end(); ?>