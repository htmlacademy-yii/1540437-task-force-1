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

<?php

use yii\helpers\Html;

if ($model->hasErrors()) : ?>
    <div class="warning-item warning-item--error">
        <h2>Ошибки заполнения формы</h2>
        <?php foreach ($model->errors as $category => $errors) : ?>
            <?= Html::tag('h3', $model->getAttributeLabel($category)); ?>
            <?php foreach ($errors as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        <?php endforeach; ?>

    </div>
<?php endif; ?>