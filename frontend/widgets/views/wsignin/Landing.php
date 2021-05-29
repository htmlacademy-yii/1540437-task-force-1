<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var string $title */
/** @var \frontend\models\forms\SigninForm $model */
/** @var \yii\widgets\ActiveForm $form */
?>

<?= Html::tag('h2', $title); ?>
<?php 
$form = ActiveForm::begin([
    'action' => \Yii::$app->user->loginUrl,
    'method' => 'POST',
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

<p>
    <?= $form->field($model, 'email')->label(null, ['class' => 'form-modal-description' ]);; ?>
</p>
<p>
    <?= $form->field($model, 'password')->label(null, ['class' => 'form-modal-description' ]); ?>
</p>

<?= Html::submitButton('Войти', ['class' => 'button']); ?>

<?php ActiveForm::end(); ?>

<?= Html::button('Закрыть', ['id' => 'close-modal', 'class' => 'form-modal-close']); ?>
