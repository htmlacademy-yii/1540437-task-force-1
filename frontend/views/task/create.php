<?php

/** @var \yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = "Публикация нового задания";
?>

<section class="create__task">
    <?= Html::tag('h1', $this->title); ?>
    <div class="create__task-main">
        <?= $this->render('_createForm', ['model' => $model]); ?>

        <div class="create__warnings">
            <div class="warning-item warning-item--advice">
                <h2>Правила хорошего описания</h2>
                <h3>Подробности</h3>
                <p>Друзья, не используйте случайный<br>
                    контент – ни наш, ни чей-либо еще. Заполняйте свои
                    макеты, вайрфреймы, мокапы и прототипы реальным
                    содержимым.</p>
                <h3>Файлы</h3>
                <p>Если загружаете фотографии объекта, то убедитесь,
                    что всё в фокусе, а фото показывает объект со всех
                    ракурсов.</p>
            </div>
            <div class="warning-item warning-item--error">
                <h2>Ошибки заполнения формы</h2>
                <h3>Категория</h3>
                <p>Это поле должно быть выбрано.<br>
                    Задание должно принадлежать одной из категорий</p>
            </div>
        </div>
    </div>
</section>