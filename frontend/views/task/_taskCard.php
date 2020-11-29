<?php

use yii\helpers\Html;

/** @var \yii\base\View $this */
/** @var \frontend\models\Tasks $model */


?>
<div class="new-task__card">
    <div class="new-task__title">
        <?php
            $title = Html::tag("h2", $model->title);
            echo Html::a($title, ['view', 'id' => $model->id], [ 'class' => 'link-regular' ]);
        ?>

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

    <span class="new-task__time">
    <?php
        if ($model->interval['d'] >= 1) {
            echo Yii::t('intl', 'interval.d', ['n' => $model->interval['d']]);
        } elseif ($model->interval['h'] > 0) {
            echo Yii::t('intl', 'interval.h', ['n' => $model->interval['h']]);
        } elseif ($model->interval['i'] >= 0) {
            echo Yii::t('intl', 'interval.i', ['n' => $model->interval['i']]);
        }
    ?>
    </span>
</div>