<?php

use app\utils\Text;
use common\widgets\Stars;
use frontend\widgets\GenderIcon;
use yii\helpers\Html;

/** @var \yii\base\View $this */
/** @var \frontend\models\User $model */
/** @var string|null $searchString */
?>


<div class="content-view__feedback-card user__search-wrapper">
    <div class="feedback-card__top">
        <div class="user__search-icon">
            <?= Html::a(GenderIcon::widget(['gender' => $model->gender]), ['view', 'id' => $model->id]); ?>
            <?= Html::tag('span', Yii::t('intl', 'tasks.count', ['n' => $model->countTasks])); ?>
            <?= Html::tag('span', Yii::t('intl', 'responses.count', ['n' =>  $model->countReviews])); ?>
        </div>
        <div class="feedback-card__top--name user__search-card">
            <p class="link-name">
                <?php
                $name = $searchString ? Text::highlight($searchString, $model->name) : $model->name;
                ?>
                <?= Html::a($name, ['view', 'id' => $model->id], ['class' => 'link-regular']); ?>
            </p>
            <?= Stars::widget(['rating' => $model->avgRating]); ?>
        </div>
        <span class="new-task__time">
            Последний раз видили <?= \Yii::$app->formatter->asInterval('auto', $model->last_logined_at); ?>
        </span>
    </div>
    <?php if ($model->categories) : ?>
        <div class="link-specialization user__search-link--bottom">
            <?php foreach ($model->categories as $category) : ?>
                <?= Html::a($category->name, null, ['class' => 'link-regular']) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>