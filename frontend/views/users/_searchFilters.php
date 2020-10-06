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
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'fieldConfig' => [
        'options' => [ 'tag' => false ]
    ],
    'options' => [
        'class' => 'search-task__form'
    ],
]);

?>

<div class="search-task__wrapper">

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

    <fieldset class="search-task__advanced">
        <?= Html::tag('legend', Yii::t('app', 'Дополнительно')); ?>
    </fieldset>

    <?= $form->field($model, 'q', [
        'template' => "{label}\n{input}",
        'inputOptions' => [ 'class' => 'input-middle input'],
        'labelOptions' => [ 'class' => 'search-task__name' ]
    ])->input('search', ['placeholder']); ?>

    <?= Html::submitButton(Yii::t('app', 'Искать'), [ 'class' => 'button' ]) ?>

    <?php ActiveForm::end();?>

</div>

<?php

/** 
<div class="search-task__wrapper">
    <form class="search-task__form" name="users" method="post" action="#">
        <?php foreach ($filterForm->fieldsets() as $legend => $attributes) : ?>
            <fieldset class="search-task__categories">
                <?= Html::tag('legend', $legend); ?>
                <?php foreach ($attributes as $attr) : ?>
                    <?= Html::activeCheckbox($filterForm, $attr, [
                        'label' => false,
                        'class' => 'visually-hidden checkbox__input'
                    ]) ?>
                    <?= Html::activeLabel($filterForm, $attr); ?>
                <?php endforeach; ?>
            </fieldset>
        <?php endforeach ?>
        <label class="search-task__name" for="110">Поиск по имени</label>
        <input class="input-middle input" id="110" type="search" name="q" placeholder="">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken(); ?>" />
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <button class="button" type="submit">Искать</button>
    </form>
</div>