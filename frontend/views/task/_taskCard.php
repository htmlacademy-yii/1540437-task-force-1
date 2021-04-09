<?php

use yii\helpers\Html;

/** @var \yii\base\View $this */
/** @var \frontend\models\Task $model */


?>



<div class="new-task__card">
    <div class="new-task__title">
        <?php
        $title = Html::tag("h2", $model->title);
        echo Html::a($title, ['view', 'id' => $model->id], ['class' => 'link-regular']);
        ?>

        <a class="new-task__type link-regular" href="#">
            <?= Html::tag('p', $model->category ? $model->category->name : null); ?>
        </a>
    </div>
    <?= Html::tag('div', null, ['class' => "new-task__icon new-task__icon--{$model->category->icon}"]); ?>
    <?= Html::tag('p', $model->description, ['class' => 'new-task_description']); ?>
    <?= Html::tag('b', \Yii::$app->formatter->asCurrency($model->budget, 'RUR'), ['class' => "new-task__price new-task__price--{$model->category->icon}"]) ;?>
    <?= Html::tag('p', 'Санкт-Петербург, Центральный район', ['class' => 'new-task__place']); ?>
    <?= Html::tag('span', \Yii::$app->getFormatter()->asInterval('d', $model->created_at), ['class' => 'new-task__time']);?>


</div>