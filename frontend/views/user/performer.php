<?php

/** @var yii\web\View $this */

use yii\helpers\Html;



/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var frontend\models\search\UserSearch $searchModel */
/** @var \frontend\models\Performer $model */

$this->title = 'Исполнители';
?>

<section class="user__search">
    <div class="user__wrapper">
        <?= $this->render('_searchSorter', ['dataProvider' => $dataProvider]); ?>
        <?php foreach ($dataProvider->getModels() as $model) : ?>
            <?= $this->render('_userCard', ['model' => $model, 'searchString' => '']); ?>
        <?php endforeach; ?>
    </div>
    <div class="new-task__pagination" style="margin: 0 -20px -20px -20px;">
        <?php if ($dataProvider->pagination) : ?>
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
        <?php endif; ?>
    </div>
</section>

<section class="search-task">
    <div class="search-task__wrapper">
        <?= $this->render('_searchFilters', [
            'model' => $searchModel
        ]); ?>
    </div>
</section>