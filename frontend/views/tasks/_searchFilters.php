<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\db\ActiveRecord[] */
/** @var frontend\models\search\TaskSearch $model */

$categoryList = ArrayHelper::map(\frontend\models\Category::find()->all(), 'id', 'name');

$form = ActiveForm::begin([
    'method' => 'post',
    'fieldConfig' => [
        'options' => ['tag' => false],
        'template' => "{input}\n{label}",
        'inputOptions' => ['class' => 'visually-hidden checkbox__input'],
        'labelOptions' => ['class' => false, 'style' => 'width: 100%;']
    ],
    'options' => [
        'tag' => false,
        'class' => 'search-task__form'
    ],
]);

?>
<fieldset class="search-task__categories">
    <?= Html::tag('legend', Yii::t('app', 'Категории')); ?>
    <?= $form->field($model, 'categoryIds')->checkboxList($categoryList, [
        'item' => function ($index, $label, $name, $checked, $value) {
            $html = Html::checkbox($name, $checked, [
                'id' => "category_idx_{$index}",
                'value' => $value,
                'class' => 'visually-hidden checkbox__input'
            ]);
            $html .= Html::label($label, "category_idx_{$index}", ['style' => 'width: 100%;']);
            return $html;
        }
    ])->label(false); ?>
</fieldset>

<fieldset class="search-task__categories">
    <?= Html::tag('legend', Yii::t('app', 'Дополнительно')); ?>

    <?= $form->field($model, 'empty')->checkbox([
        'class' => 'visually-hidden checkbox__input',
    ], false); ?>
    <?= $form->field($model, 'remoteWork')->checkbox([
        'class' => 'visually-hidden checkbox__input',
    ], false); ?>
</fieldset>

<?= $form->field($model, 'period', [
    'template' => "{label}\n{input}",
    'inputOptions' => ['class' => 'multiple-select input'],
    'labelOptions' => ['class' => 'search-task__name']
])->dropDownList($model->periodList()); ?>

<?= $form->field($model, 'qname', [
    'template' => "{label}\n{input}",
    'labelOptions' => ['class' => 'search-task__name']
])->input('search', [
    'placeholder' => false,
    'class' => 'input-middle input'
]); ?>

<?= Html::submitButton(Yii::t('app', 'Искать'), ['class' => 'button']) ?>

<?php ActiveForm::end(); ?>