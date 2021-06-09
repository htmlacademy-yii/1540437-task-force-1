<?php

/** @var yii\web\View $this */
/** @var frontend\models\forms\SignupForm $model */

use frontend\models\City;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;



$cityList = ArrayHelper::merge($model::cityMap(), ArrayHelper::map(City::find()->all(), 'id', 'name'));
sort($cityList);

?>


<section class="registration__user">
    <?= Html::tag('h1', 'Регистрация аккаунта'); ?>
    <div class="registration-wrapper">
        <?php $form = ActiveForm::begin([
            'options' => [
                'csrf' => false,
                'class' => 'registration__user-form form-create'
            ],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'errorOptions' => ['tag' => 'span'],
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
        <?= $form->field($model, 'email')->textarea(['placeholder' => 'Ваша электронная почта']); ?>
        <?= $form->field($model, 'username')->textarea(['placeholder' => 'Ваше имя']); ?>
        <?= $form->field($model, 'city')->dropDownList($cityList, ['class' => 'multiple-select input town-select registration-town']); ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Придумайте пароль', 'autocomplete' => 'on']); ?>

        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken(); ?>" />

        <?= Html::submitButton('Cоздать аккаунт', ['class' => 'button button__registration']); ?>

        <?php ActiveForm::end(); ?>
    </div>
</section>