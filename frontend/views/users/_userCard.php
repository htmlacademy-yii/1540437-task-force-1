<?php

use common\widgets\Stars;
use frontend\widgets\GenderIcon;
use yii\helpers\Html;

/** @var \yii\base\View $this */
/** @var \frontend\models\User $model */
?>


<div class="content-view__feedback-card user__search-wrapper">
    <div class="feedback-card__top">
        <div class="user__search-icon">
            <?= Html::a(GenderIcon::widget(['gender' => $model->gender]), "#{$model->id}"); ?>
            <?= Html::tag('span', Yii::t('intl', 'tasks.count', ['n' => count($model->performerTasks)])); ?>
            <?= Html::tag('span', Yii::t('intl', 'responses.count', ['n' => $model->countResponses])); ?>
        </div>
        <div class="feedback-card__top--name user__search-card">
            <p class="link-name">
                <?= Html::a("{$model->lastName} {$model->firstName}", "#{$model->id}", ['class' => 'link-regular']); ?>
            </p>
            <?= Stars::widget(['rating' => $model->avgRating]); ?>
        </div>
        <span class="new-task__time">
            <?php
            if ($model->lastLogin['d'] > 0) {
                echo Yii::t('intl', 'users.lastlogin.d', ['gender' => strtolower($model->gender), 'n' => $model->lastLogin['d']]);
            } elseif ($model->lastLogin['h'] > 0) {
                echo Yii::t('intl', 'users.lastlogin.h', ['gender' => strtolower($model->gender), 'n' => $model->lastLogin['h']]);
            } elseif ($model->lastLogin['i'] >= 0) {
                echo Yii::t('intl', 'users.lastlogin.i', ['gender' => strtolower($model->gender), 'n' => $model->lastLogin['i']]);
            } ?>
        </span>
    </div>
    <div style="white-space: pre;">
        <?= print_r($model->performerTasks, true) ?>
    </div>
    <?php if ($model->categories) : ?>
        <div class="link-specialization user__search-link--bottom">
            <?php foreach ($model->categories as $category) : ?>
                <?= Html::a($category->name, null, ['class' => 'link-regular']) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>