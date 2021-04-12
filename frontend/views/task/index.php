<?php

/** @var yii\web\View $this */

use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var frontend\models\search\TaskSearch $searchModel */

$this->title = 'Задания';
?>

<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        <?php foreach ($dataProvider->getModels() as $model) : ?>
            <?= $this->render('_taskCard', ['model' => $model, 'searchString' => $searchModel->searchByName]); ?>
        <?php endforeach; ?>
    </div>
    <?php /** Пагинация */ ?>
    <div class="new-task__pagination">
        <?= LinkPager::widget([
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
        <?= $this->render('_searchFilters', ['model' => $searchModel]); ?>
    </div>
</section>