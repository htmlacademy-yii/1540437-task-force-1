<?php

/** @var frontend\models\User $model */
/** @var frontend\models\TaskResponses $taskResponse */

use yii\helpers\Html;

$countResponses = count($model->taskResponses);
?>
<div class="content-view__feedback">
    <?= Html::tag('h2', Yii::t('app', 'Reviews <span>({0})</span>', $countResponses)); ?>
    <div class="content-view__feedback-wrapper reviews-wrapper">
        <?php foreach ($model->taskResponses as $taskResponse) : ?>
            <div class="feedback-card__reviews">
                <p class="link-task link">
                    <?= Yii::t('app', 'Task'); ?>
                    <?= Html::a($taskResponse->task->title, ['/task/view', 'id' => $taskResponse->task_id], ['class' => 'link-regular']); ?>
                </p>
                <div class="card__review">
                    <?= Html::a('<img src="/img/man-glasses.jpg" width="55" height="54">', ['user/view', 'id' => $taskResponse->user_id]); ?>
                    <div class="feedback-card__reviews-content">
                        <p class="link-name link">
                            <?= Html::a($taskResponse->user->fullName, ['/user/view', 'id' => $taskResponse->user->id], ['class' => 'link-regular']); ?>
                            <!-- <a href="#" class="link-regular">Астахов Павел</a> -->
                        </p>
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
        <?php endforeach; ?>

    </div>
</div>