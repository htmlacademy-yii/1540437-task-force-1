<?php



use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\Pagination $pager */
/** @var frontend\models\forms\CategoryFilterForm $categoryFilterForm */

$this->title = 'Исполнители';
?>

<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <li class="user__search-item user__search-item--current">
                <a href="#" class="link-regular">Рейтингу</a>
            </li>
            <li class="user__search-item">
                <a href="#" class="link-regular">Числу заказов</a>
            </li>
            <li class="user__search-item">
                <a href="#" class="link-regular">Популярности</a>
            </li>
        </ul>
    </div>

    <?php foreach ($models as $model) : ?>
        <?= $this->render('_userCard', ['model' => $model]); ?>
    <?php endforeach; ?>
</section>
<section class="search-task">
    <?= $this->render('_seachFilters', [
        'filterForm' => $categoryFilterForm
    ]); ?>
</section>