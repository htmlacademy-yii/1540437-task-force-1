<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \yii\db\ActiveRecord[] */
/** @var frontend\models\search\UserSearch $model */

$categoryList = ArrayHelper::map(\frontend\models\Category::find()->all(), 'id', 'name');

$form = ActiveForm::begin([
    'method' => 'post',
    'fieldConfig' => [
        'options' => [ 'tag' => false ],
        'template' => "{input}\n{label}",
        'inputOptions' => [ 'class' => 'visually-hidden checkbox__input'],
        'labelOptions' => [ 'class' => true ]
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
            'item' => function($index, $label, $name, $checked, $value) {
                $html = Html::checkbox($name, $checked, [
                    'id' => "category_idx_{$index}",
                    'value' => $value,
                    'class' => 'visually-hidden checkbox__input'
                ]);
                $html .= Html::label($label, "category_idx_{$index}");
                return $html;
            }
        ])->label(false); ?>
    </fieldset>

    <fieldset class="search-task__categories">
        <?= Html::tag('legend', Yii::t('app', 'Дополнительно')); ?>
        
        <?= $form->field($model, 'isFreeNow')->checkbox([
            'class' => 'visually-hidden checkbox__input',
        ], false); ?>

        <?= $form->field($model, 'isOnline')->checkbox([
            'class' => 'visually-hidden checkbox__input',
        ], false); ?>

        <?= $form->field($model, 'isHasResponses')->checkbox([
            'class' => 'visually-hidden checkbox__input',
        ], false); ?>

        <?= $form->field($model, 'isFavorite')->checkbox([
            'class' => 'visually-hidden checkbox__input',
        ], false); ?>
    </fieldset>

    <?= $form->field($model, 'qname', [
        'template' => "{label}\n{input}",
        'labelOptions' => [ 'class' => 'search-task__name' ]
    ])->input('search', [
        'placeholder' => false,
        'class' => 'input-middle input'
    ]); ?>

    <?= Html::submitButton(Yii::t('app', 'Искать'), [ 'class' => 'button' ]) ?>

<?php ActiveForm::end();?>