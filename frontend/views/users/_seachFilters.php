<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\forms\CategoryFilterForm $filterForm */

?>

<div class="search-task__wrapper">
    <form class="search-task__form" name="users" method="post" action="#">
        <?php foreach ($filterForm->fieldsets() as $legend => $attributes) : ?>
            <fieldset class="search-task__categories">
                <?= Html::tag('legend', $legend); ?>
                <?php foreach ($attributes as $attr) : ?>
                    <?= Html::activeCheckbox($filterForm, $attr, [
                        'label' => false,
                        'class' => 'visually-hidden checkbox__input'
                    ]) ?>
                    <?= Html::activeLabel($filterForm, $attr); ?>
                <?php endforeach; ?>
            </fieldset>
        <?php endforeach ?>
        <label class="search-task__name" for="110">Поиск по имени</label>
        <input class="input-middle input" id="110" type="search" name="q" placeholder="">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken(); ?>" />
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <button class="button" type="submit">Искать</button>
    </form>
</div>