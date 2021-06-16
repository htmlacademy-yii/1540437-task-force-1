<?php

/** @var \yii\web\View $this */
/** @var \frontend\models\forms\TaskForm $model */

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "Публикация нового задания";
?>
<section class="create__task">
    <?= Html::tag('h1', $this->title); ?>
    <div class="create__task-main">
        <?= $this->render('_createForm', ['model' => $model]); ?>
        <?php Pjax::begin([
            'formSelector' => '#create-task-form',
            'options' => [
                'class' => 'create__warnings'
            ]
        ]); ?>
        <?= $this->render('_create-warnings', ['model' => $model]); ?>
        <?php Pjax::end(); ?>

    </div>

    <?php if (isset($this->blocks['task-form-submit-button'])) : ?>
        <?= $this->blocks['task-form-submit-button'] ?>
    <?php endif; ?>
</section>