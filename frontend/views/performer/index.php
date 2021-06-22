<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var frontend\models\search\UserSearch $searchModel */

$this->title = 'Исполнители';
?>

<section class="user__search">
    <div class="user__wrapper">
        <?= $this->render('_searchSorter', ['dataProvider' => $dataProvider]); ?>
        <?php foreach ($dataProvider->getModels() as $model) : ?>
            <?= $this->render('_userCard', ['model' => $model, 'searchString' => $searchModel->qname]); ?>
        <?php endforeach; ?>
    </div>
    <?php if ($dataProvider->pagination && $dataProvider->totalCount > 0) : ?>
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
    <?php endif; ?>
</section>

<section class="search-task">
    <div class="search-task__wrapper">
        <?= $this->render('_searchFilters', [
            'model' => $searchModel
        ]); ?>
    </div>
</section>