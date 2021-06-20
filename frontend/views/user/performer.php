<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var frontend\models\search\UserSearch $searchModel */

$this->title = 'Исполнители';
?>

<section class="user__search">
    <div class="user__wrapper">
        
        <?php foreach ($dataProvider->getModels() as $model) : ?>

        <p>
            User: <?= $model->id; ?>
            Rating: <?= $model->avgRating; ?>
            Reviews: <?= $model->countReviews; ?>
        </p>

            
        <?php endforeach; ?>
    </div>
    <div class="new-task__pagination" style="margin: 0 -20px -20px -20px;">
        <?= yii\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'new-task__pagination-list'],
            'nextPageLabel' => '',
            'prevPageLabel' => '',
            'prevPageCssClass' => 'pagination__item',
            'nextPageCssClass' => 'pagination__item',
            'pageCssClass' => 'pagination__item',
            'activePageCssClass' => 'pagination__item--current'
        ]); ?>
    </div>
</section>

<section class="search-task">
    <div class="search-task__wrapper">
        
    </div>
</section>