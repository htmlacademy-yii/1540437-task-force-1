<?php

use common\widgets\Interval;
use yii\helpers\Html;

/** @var frontend\models\User $model */
/** @var yii\web\View $this */

$this->title = "Профиль";

?>

<div class="main-container page-container">
    <section class="content-view">
        <div class="user__card-wrapper">
            <div class="user__card">
                <img src="/img/man-hat.png" width="120" height="120" alt="Аватар пользователя">
                <div class="content-view__headline">
                    <?= Html::tag('h1', $model->lastName . " " . $model->firstName); ?>
                    <p>Россия, <?= $model->city->name; ?>, 30 лет</p>
                    <div class="profile-mini__name five-stars__rate">
                        <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                        <b>4.25</b>
                    </div>
                    <b class="done-task">
                        Выполнил <?= Yii::t('intl', 'tasks.count', ['n' => $model->getCountPerformerTasks()]); ?>
                    </b>
                    <b class="done-review">
                        Получил <?= Yii::t('intl', 'responses.count', ['n' => 6]); ?>
                    </b>
                </div>
                <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                    <span>
                        <?= Interval::widget(['interval' => $model->getLastLogin(), 'gender' => $model->getGender(), 'type' => 'users.lastlogin']); ?>
                    </span>
                    <a href="#"><b></b></a>
                </div>
            </div>
            <div class="content-view__description">
                <?= Html::tag('p', $model->profile->about); ?>
            </div>
            <div class="user__card-general-information">
                <div class="user__card-info">
                    <h3 class="content-view__h3">Специализации</h3>
                    <div class="link-specialization">
                        <?php foreach ($model->categories as $category) : ?>
                            <?= Html::a($category->name, ["#"], ['class' => 'link-regular']); ?>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($model->is_contact_public) : ?>
                        <h3 class="content-view__h3">Контакты</h3>
                        <div class="user__card-link">
                            <a class="user__card-link--tel link-regular" href="#">8 (555) 172 83 69</a>
                            <a class="user__card-link--email link-regular" href="#">Kumarm@mail.ru</a>
                            <a class="user__card-link--skype link-regular" href="#">Kumarm</a>
                        </div>
                    <?php endif; ?>

                </div>
                <div class="user__card-photo">
                    <h3 class="content-view__h3">Фото работ</h3>
                    <a href="#"><img src="/img/rome-photo.jpg" width="85" height="86" alt="Фото работы"></a>
                    <a href="#"><img src="/img/smartphone-photo.png" width="85" height="86" alt="Фото работы"></a>
                    <a href="#"><img src="/img/dotonbori-photo.png" width="85" height="86" alt="Фото работы"></a>
                </div>
            </div>
        </div>
        <div class="content-view__feedback">
            <h2>Отзывы<span>(2)</span></h2>
            <div class="content-view__feedback-wrapper reviews-wrapper">
                <div class="feedback-card__reviews">
                    <p class="link-task link">Задание <a href="#" class="link-regular">«Выгулять моего боевого петуха»</a></p>
                    <div class="card__review">
                        <a href="#"><img src="/img/man-glasses.jpg" width="55" height="54"></a>
                        <div class="feedback-card__reviews-content">
                            <p class="link-name link"><a href="#" class="link-regular">Астахов Павел</a></p>
                            <p class="review-text">
                                Кумар сделал всё в лучшем виде. Буду обращаться к нему в будущем, если
                                возникнет такая необходимость!
                            </p>
                        </div>
                        <div class="card__review-rate">
                            <p class="five-rate big-rate">5<span></span></p>
                        </div>
                    </div>
                </div>
                <div class="feedback-card__reviews">
                    <p class="link-task link">Задание <a href="#" class="link-regular">«Повесить полочку»</a></p>
                    <div class="card__review">
                        <a href="#"><img src="/img/woman-glasses.jpg" width="55" height="54"></a>
                        <div class="feedback-card__reviews-content">
                            <p class="link-name link"><a href="#" class="link-regular">Морозова Евгения</a></p>
                            <p class="review-text">
                                Кумар приехал позже, чем общал и не привез с собой всех
                                инстументов. В итоге пришлось еще ходить в строительный магазин.
                            </p>
                        </div>
                        <div class="card__review-rate">
                            <p class="three-rate big-rate">3<span></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__chat">

        </div>
    </section>
</div>