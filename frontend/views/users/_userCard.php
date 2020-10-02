<?php

use yii\helpers\Html;

/** @var \yii\base\View $this */
/** @var \frontend\models\Users $model */
?>


<div class="content-view__feedback-card user__search-wrapper">
    <div class="feedback-card__top">
        <div class="user__search-icon">
            <?= Html::a("<img src=\"/img/{$model->iconByGender}-glasses.jpg\" width=\"65\" height=\"65\">", "#{$model->id}"); ?>
            <?= Html::tag('span', Yii::t('intl', 'tasks.count', ['n' => $model->countPerformerTasks])); ?>
            <?= Html::tag('span', Yii::t('intl', 'responses.count', ['n' => $model->countResponses])); ?>
        </div>
        <div class="feedback-card__top--name user__search-card">
            <p class="link-name">
                <?= Html::a($model->fullName, "#{$model->id}", ['class' => 'link-regular']); ?>
            </p>
            <?= str_repeat('<span></span>', floor($model->avgEvaluation)) ?>
            <?= ($fmax = 5 - floor($model->avgEvaluation)) > 0 ? str_repeat('<span class="star-disabled"></span>', $fmax) : ''; ?>
            <?= Html::tag('b', $model->avgEvaluation); ?>
            <?= Html::tag('p', $model->about, ['class' => 'user__search-content']); ?>
        </div>
        <span class="new-task__time">
        <?php
        if ($model->lastLogin['d'] > 0) {
            echo Yii::t('intl', 'users.lastlogin.d', ['gender' => $model->gender, 'n' => $model->lastLogin['d']]);
        } elseif ($model->lastLogin['h'] > 0) {
            echo Yii::t('intl', 'users.lastlogin.h', ['gender' => $model->gender, 'n' => $model->lastLogin['h']]);
        } elseif ($model->lastLogin['i'] >= 0) {
            echo Yii::t('intl', 'users.lastlogin.i', ['gender' => $model->gender, 'n' => $model->lastLogin['i']]);
        }?>
        </span>
    </div>
    <?php if ($model->categories) : ?>
        <div class="link-specialization user__search-link--bottom">
            <?php foreach ($model->categories as $category) : ?>
                <?= Html::a($category->name, null, ['class' => 'link-regular']) ?>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="link-specialization user__search-link--bottom">
            <a href="#" class="link-regular">Ремонт</a>
            <a href="#" class="link-regular">Курьер</a>
            <a href="#" class="link-regular">Оператор ПК</a>
        </div>
    <?php endif; ?>

</div>