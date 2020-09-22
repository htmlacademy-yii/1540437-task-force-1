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
            <?= Html::tag('p', $model->category->name); ?>
        </a>
    </div>
    <?= Html::tag('div', null, [ 'class' => "new-task__icon new-task__icon--{$model->category->icon}" ]);?>
    <?= Html::tag('p', $model->description, ['class' => 'new-task_description']); ?>
    <?= Html::tag('b', "{$model->budget} <b> ₽</b>", ['class' => "new-task__price new-task__price--{$model->category->icon}"]); ?>
    <p class="new-task__place">Санкт-Петербург, Центральный район</p>
    <span class="new-task__time">4 часа назад</span>
</div>
