<?php
/** @var frontend\models\User $model */

use yii\helpers\Html;

?>
<div class="content-view__feedback">
    <?= Html::tag('h2', Yii::t('app', 'Reviews <span>({0})</span>', 2)); ?>

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