<?php



/** @var frontend\models\User $model */
/** @var frontend\models\UserReview[] $reviews */
/** @var frontend\models\UserReview $review */

use yii\helpers\Html;

$reviewsCount = count($model->userReviews);
?>
<div class="content-view__feedback">
    <?= Html::tag('h2', Yii::t('app', 'Reviews <span>({0})</span>', $reviewsCount)); ?>
    <div class="content-view__feedback-wrapper reviews-wrapper">
        <?php foreach ($model->userReviews as $review) : ?>
            <div class="feedback-card__reviews">
                <p class="link-task link">
                    <?= Yii::t('app', 'Task'); ?>
                    <?= Html::a($review->task->title, ['/task/view', 'id' => $review->task->id], ['class' => 'link-regular']); ?>
                </p>
                <div class="card__review">
                    <?= Html::a('<img src="/img/man-glasses.jpg" width="55" height="54">', ['user/view', 'id' => $review->task->performer? $review->task->performer->id: null]); ?>
                    <div class="feedback-card__reviews-content">
                        <p class="link-name link">
                            <?= Html::a($review->task->customer->name, ['/user/view', 'id' => $review->task->customer->id], ['class' => 'link-regular']); ?>
                            <!-- <a href="#" class="link-regular">Астахов Павел</a> -->
                        </p>
                        <p class="review-text">
                            <?= $review->comment ?>
                            <!-- Кумар сделал всё в лучшем виде. Буду обращаться к нему в будущем, если
                            возникнет такая необходимость! -->
                        </p>
                    </div>
                    <div class="card__review-rate">
                        <p class="five-rate big-rate"><?= $review->rate; ?><span></span></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>