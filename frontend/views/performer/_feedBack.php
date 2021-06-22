<?php



/** @var frontend\models\Performer $model */
/** @var frontend\models\UserReview[] $reviews */
/** @var frontend\models\UserReview $review */

use yii\helpers\Html;

$reviewsCount = count($model->taskReviews);
?>
<div class="content-view__feedback">
    <?= Html::tag('h2', Yii::t('app', 'Reviews <span>({0})</span>', $reviewsCount)); ?>
    <div class="content-view__feedback-wrapper reviews-wrapper">
        <?php foreach ($model->taskReviews as $review) : ?>
            <div class="feedback-card__reviews">
                <p class="link-task link">
                    <?= Yii::t('app', 'Task'); ?>
                    <?= Html::a($review->task->title, ['/task/view', 'id' => $review->task->id], ['class' => 'link-regular']); ?>
                </p>
                <div class="card__review">
                    <?= Html::a('<img src="/img/man-glasses.jpg" width="55" height="54">', ['user/view', 'id' => $review->performer->id]); ?>
                    <div class="feedback-card__reviews-content">
                        <p class="link-name link">
                            <?= Html::a($review->customer->name, ['/user/view', 'id' => $review->customer->id], ['class' => 'link-regular']); ?>
                            <!-- <a href="#" class="link-regular">Астахов Павел</a> -->
                        </p>
                        <p class="review-text">
                            <?= $review->comment ?>
                        </p>
                    </div>
                    <div class="card__review-rate">
                        <?php $rateTagClass = $review->rate > 3 ? 'five-rate big-rate' : 'three-rate big-rate'; ?>
                        <?= Html::tag('p', "{$review->rate}<span></span>", ['class' => $rateTagClass]); ?>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>