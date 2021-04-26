<?php

/** @var frontend\models\User $model */

use yii\helpers\Html;
?>

<?php if ($model->is_contact_public) : ?>
    <?= Html::tag('h3', Yii::t('app', 'Contacts'), [ 'class' => 'content-view__h3' ]); ?>
    <div class="user__card-link">
        <?= $model->phone ? Html::a($model->phone, '#', [ 'class' => 'user__card-link--tel link-regular' ]) : null; ?>
        <?= $model->email ? Html::a($model->email, '#', [ 'class' => 'user__card-link--email link-regular' ]) : null; ?>
        <?= $model->skype ? Html::a($model->skype, '#', [ 'class' => 'user__card-link--skype link-regular' ]) : null; ?>
    </div>
<?php endif; ?>