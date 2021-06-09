<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var string $title */
/** @var bool $isRemoteLogin */
/** @var \frontend\models\forms\SigninForm $model */
/** @var \yii\widgets\ActiveForm $form */
?>


<?php

echo Html::tag('h2', $title);

$form = ActiveForm::begin([
    'id' => $id,
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'action' => \Yii::$app->user->loginUrl,
    'method' => 'POST',
    'fieldConfig' => [
        'options' => [
            'style' => [
                'display' => 'flex',
                'flex-direction' => 'column'
            ]

        ],
        'inputOptions' => [
            'class' => 'input textarea',
            'rows' => 1,
        ],
        'labelOptions' => [
            'class' => 'form-modal-description'
        ]
    ]
]);

?>

<?= $form->field($model, 'email'); ?>
<?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'on']); ?>

<?= Html::submitButton('Войти', ['class' => 'button']); ?>

<?php ActiveForm::end(); ?>

<?= Html::button('Закрыть', ['id' => 'close-modal', 'class' => 'form-modal-close']); ?>

<?php

?>