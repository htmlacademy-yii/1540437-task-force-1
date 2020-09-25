<?php

use yii\helpers\Html;

/** @var \yii\base\View $this */
/** @var \frontend\models\Tasks $model */


?>
<div class="new-task__card">
    <div class="new-task__title">
        <a href="#" class="link-regular">
            <?= Html::tag("h2", $model->title); ?>
        </a>
        <a class="new-task__type link-regular" href="#">
            <?= Html::tag('p', $model->category ? $model->category->name : null); ?>
        </a>
    </div>
    <?= Html::tag('div', null, ['class' => "new-task__icon new-task__icon--{$model->category->icon}"]); ?>
    <?= Html::tag('p', $model->description, ['class' => 'new-task_description']); ?>
    <?php
    if ($model->budget) {
        echo Html::tag('b', \Yii::$app->formatter->asCurrency($model->budget, 'RUR'), ['class' => "new-task__price new-task__price--{$model->category->icon}"]);
    }

    if ($model->city) {
        echo Html::tag('p', $model->city->name, ['class' => 'new-task__place']);
    }
    ?>

    <?= Html::tag('span', $model->interval(), ['class' => 'new-task__time']); ?>
</div>