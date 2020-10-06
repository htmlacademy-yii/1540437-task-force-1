<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var frontend\models\search\UserSearch $searchModel */

use yii\helpers\Html;

$this->title = 'Исполнители';
?>

<section class="user__search">
    <?= $this->render('_searchSorter', [ 'dataProvider' => $dataProvider ]); ?>

    <?php foreach ($dataProvider->getModels() as $model) : ?>
        <?= $this->render('_userCard', ['model' => $model]); ?>
    <?php endforeach; ?>
</section>
<section class="search-task">
    <?= $this->render('_searchFilters', [
        'model' => $searchModel
        // 'filterForm' => $categoryFilterForm
    ]); ?>
</section>