<?php

/** @var yii\web\View $this */
/** @var frontend\models\forms\SignupForm $model */

use frontend\models\City;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
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
                'options' => [
                    'tag' => false,
                ],
                'inputOptions' => [
                    'class' => 'input textarea',
                    'rows' => 1,
                ],
                'labelOptions' => [
                    'class' => false
                ],
                'hintOptions' => [
                    'tag' => 'span',
                    'class' => false
                ]
            ]
            
        ]); ?>
        <?= $form->field($model, 'email')->textarea(['placeholder' => 'kumarm@mail.ru'])->label(null, ['class' => 'input-danger']); ?>
        <?= $form->field($model, 'username')->textarea(['placeholder' => 'Мамедов Кумар']); ?>
        <?= $form->field($model, 'city')->dropDownList($cityList, ['class' => 'multiple-select input town-select registration-town']); ?>
        <?= $form->field($model, 'password')->input('password'); ?>

        <input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />

        <?= Html::submitButton('Cоздать аккаунт', [ 'class' => 'button button__registration' ]); ?>

        <?php ActiveForm::end(); ?>
    </div>
</section>

