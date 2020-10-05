<?php

/** @var yii\web\View $this */

use Codeception\Lib\Actor\Shared\Retry;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\data\Sort $sorter */

$sorter = $dataProvider->getSort();
?>

<div class="user__search-link">
    <?= Html::tag('p', Yii::t('app', 'Сортировать по:')); ?>
    <?= Html::ul($sorter->attributes, [
        'class' => 'user__search-list',
        'item' => function ($item, $index) use ($sorter) {
            $itemOptions['class'] = 'user__search-item';
            if (isset($sorter->attributeOrders[$index])) {
                Html::addCssClass($itemOptions, 'user__search-item--current');
            }

            return Html::tag('li', $sorter->link($index, ['class' => 'link-regular']), $itemOptions);            
        }
    ]); ?>
</div>
       
