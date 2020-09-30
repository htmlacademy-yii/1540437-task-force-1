<?php

use yii\helpers\Html;

/** @var \yii\base\View $this */
/** @var \frontend\models\Users $model */

?>

<div class="content-view__feedback-card user__search-wrapper">
    <div class="feedback-card__top">
        <div class="user__search-icon">
            <?= Html::a("<img src=\"/img/{$model->iconByGender}-glasses.jpg\" width=\"65\" height=\"65\">", "#{$model->id}"); ?>
            <?= Html::tag('span', count($model->performerTasks) . ' заданий'); ?>
            <?= Html::tag('span', count($model->taskResponses) . '  отзывов'); ?>
        </div>
        <div class="feedback-card__top--name user__search-card">
            <p class="link-name">
                <?= Html::a("ID: {$model->id} {$model->getFullName()}", "#{$model->id}", ['class' => 'link-regular']);?>
            </p>
            <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
            <b>4.25</b>
            <p class="user__search-content">
                <?= $model->about ?>
            </p>
        </div>
        <span class="new-task__time">
            <?= $model->lastLogin ?>
        </span>
    </div>
    <?php if ($model->categories) : ?>
        <div class="link-specialization user__search-link--bottom">
            <?php foreach ($model->categories as $category) : ?>  
                <?= Html::a($category->name, null, ['class' => 'link-regular']) ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="link-specialization user__search-link--bottom">
            <a href="#" class="link-regular">Ремонт</a>
            <a href="#" class="link-regular">Курьер</a>
            <a href="#" class="link-regular">Оператор ПК</a>
        </div>
    <?php endif; ?>
    
</div>