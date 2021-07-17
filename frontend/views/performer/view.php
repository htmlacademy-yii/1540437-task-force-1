<?php

use common\widgets\Interval;
use common\widgets\Stars;
use yii\helpers\Html;

/** @var frontend\models\Performer $model */
/** @var yii\web\View $this */

$this->title = "Профиль";

?>

<div class="main-container page-container">
    <section class="content-view">
        <div class="user__card-wrapper">
            <div class="user__card">
                <img src="/img/man-hat.png" width="120" height="120" alt="Аватар пользователя">
                <div class="content-view__headline">
                    <?= Html::tag('h1', $model->name); ?>
                    <p>
                        Россия,
                        <?= $model->city ? $model->city->name : ''; ?>,
                        <?= Yii::$app->formatter->asInterval('y', $model->profile->birth_date); ?>
                    </p>
                    <div class="profile-mini__name five-stars__rate">
                        <?= Stars::widget(['rating' => $model->avgRating]); ?>
                    </div>
                    <b class="done-task">
                        <?= Yii::t('intl', 'tasks.completed', ['n' => $model->countCompletedTasks]); ?>
                    </b>
                    <b class="done-review">
                        <?= Yii::t('intl', 'tasks.reviews', ['n' => $model->countReviews]); ?>
                    </b>
                </div>
                <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                    <span>
                        <?php Interval::widget(['interval' => Yii::$app->formatter->asDateInterval($model->lastLogin), 'gender' => $model->gender, 'type' => 'users.lastlogin']);
                        ?>
                    </span>
                    <a href="#"><b></b></a>
                </div>
            </div>
            <div class="content-view__description">
                <?= Html::tag('p', $model->profile->about); ?>
            </div>
            <div class="user__card-general-information">
                <div class="user__card-info">
                    <?= Html::tag('h3', Yii::t('app', 'Specializations'), ['content-view__h3']); ?>
                    <div class="link-specialization">
                        <?php foreach ($model->skils as $skil) : ?>
                            <?= Html::a($skil->name, ["#"], ['class' => 'link-regular']); ?>
                        <?php endforeach; ?>
                    </div>
                    <?php $this->render('_contacts', ['model' => $model]);
                    ?>
                </div>
                <div class="user__card-photo">
                    <h3 class="content-view__h3">Фото работ</h3>
                    <a href="#"><img src="/img/rome-photo.jpg" width="85" height="86" alt="Фото работы"></a>
                    <a href="#"><img src="/img/smartphone-photo.png" width="85" height="86" alt="Фото работы"></a>
                    <a href="#"><img src="/img/dotonbori-photo.png" width="85" height="86" alt="Фото работы"></a>
                </div>
            </div>
        </div>
        <?php echo $this->render('_feedBack', ['model' => $model]); ?>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__chat pre">

        </div>
    </section>
</div>

<?php

$css = <<< CSS
    .pre {
        white-space: pre-wrap;
    }
CSS;

$this->registerCss($css);
