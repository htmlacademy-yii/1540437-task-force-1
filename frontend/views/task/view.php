<?php

use common\widgets\Interval;
use common\widgets\Stars;
use frontend\models\search\TaskSearch;
use frontend\widgets\GenderIcon;
use yii\helpers\Html;
use yii\web\YiiAsset;

YiiAsset::register($this);

/** @var \yii\web\View $this */
/** @var \frontend\models\Task $model */

$this->title = "{$model->title}::" . Yii::$app->name;

?>

<section class="content-view">
    <div class="content-view__card">
        <div class="content-view__card-wrapper">
            <!-- TODO: Add translate, Interval widget -->
            <div class="content-view__header">
                <div class="content-view__headline">
                    <?= Html::tag('h1', $model->title); ?>
                    <span>Размещено в категории
                        <?= Html::a($model->category->name, ['task/index'], [
                            'class' => 'link-regular',
                            'data-method' => 'post',
                            'data-params' => [
                                (new TaskSearch)->formName() . "[categoryIds][]" => $model->category->id,
                            ]
                        ]); ?>
                        <?= \Yii::$app->formatter->asInterval('d', $model->created_at);?>
                        
                    </span>
                </div>
                <?= $model->budget ?
                    Html::tag('b', \Yii::$app->formatter->asCurrency($model->budget, 'RUR'), ['class' => "new-task__price content-view-price new-task__price--{$model->category->icon}"]) :
                    ''; ?>
                <?= Html::tag('div', null, ['class' => "new-task__icon content-view-icon new-task__icon--{$model->category->icon}"]); ?>
            </div>
            <!-- TODO: Add translate -->
            <div class="content-view__description">
                <?= Html::tag('h3', 'Общее описание', ['class' => 'content-view__h3']); ?>
                <?= Html::tag('p', $model->description); ?>
            </div>
            <!-- TODO: Услвоие отрисовки блока, перебор вложений -->
            <div class="content-view__attach">
                <?= Html::tag('h3', \Yii::t('app', 'Attachments'), ['class' => 'content-view__h3']); ?>
                <a href="#">my_picture.jpeg</a>
                <a href="#">agreement.docx</a>
            </div>
            <!-- TODO: Условия, отрисовки локации -->
            <div class="content-view__location">
                <?= Html::tag('h3', \Yii::t('app', 'Location'), ['class' => 'content-view__h3']); ?>
                <div class="content-view__location-wrapper">
                    <div class="content-view__map">
                        <?= Html::a(Html::img('/img/map.jpg', ['width' => 361, 'height' => 292, 'alt' => 'Москва, Новый арбат, 23 к. 1']), '#'); ?>
                    </div>
                    <div class="content-view__address">
                        <?= Html::tag('span', 'Москва', ['class' => 'address__town']); ?> <br />
                        <?= Html::tag('span', 'Новый арбат, 23 к. 1'); ?>
                        <?= Html::tag('p', 'Вход под арку, код домофона 1122'); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- TODO: Add button translate -->
        <div class="content-view__action-buttons">
            <?= Html::button('Откликнуться', ['class' => 'button button__big-color response-button open-modal', 'data-for' => 'response-form']); ?>
            <?= Html::button('Отказаться',   ['class' => 'button button__big-color refusal-button open-modal', 'data-for' => 'refuse-form']); ?>
            <?= Html::button('Завершить',    ['class' => 'button button__big-color request-button open-modal', 'data-for' => 'complete-form']); ?>
        </div>
    </div>
    <!-- TODO: Add translate -->
    <div class="content-view__feedback">
        <?= $model->responses ?
            Html::tag('h2', \Yii::t('app', 'Feedbacks') . " <span>(" . count($model->responses) . ")</span>") :
            "На Вашу заявку еще никто не откликнулся";
        ?>
        <?php if ($model->responses) : ?>
            <!-- TODO: Верстка, переводы -->
            <div class="content-view__feedback-wrapper">
                <?php foreach ($model->responses as $taskResponse) : ?>
                    <div class="content-view__feedback-card">
                        <div class="feedback-card__top">
                            <a href="#">
                                <?php GenderIcon::widget(['gender' => $taskResponse->performer->gender, 'htmlOptions' => ['width' => 55, 'height' => 55]]); ?>
                            </a>
                            <div class="feedback-card__top--name">
                                <p>
                                    <?= Html::a($taskResponse->performer->name, "#", ['class' => 'link-regular']); ?>
                                </p>
                                <?= Stars::widget(['rating' => $taskResponse->rate]); ?>
                            </div>
                            <span class="new-task__time">
                                <?= \Yii::$app->formatter->asInterval('d', $taskResponse->created_at); ?>
                            </span>
                        </div>
                        <div class="feedback-card__content">
                            <?= Html::tag('p', $taskResponse->comment); ?>
                            <?= $taskResponse->amount ? Html::tag('span', \Yii::$app->formatter->asCurrency($taskResponse->amount, 'RUR')) : ''; ?>
                        </div>
                        <div class="feedback-card__actions">
                            <?= Html::a(\Yii::t('app', 'Confirm'), '', ['class' => 'button__small-color request-button button', 'type' => 'button']); ?>
                            <?= Html::a(\Yii::t('app', 'Deny'), '', ['class' => 'button__small-color refusal-button button', 'type' => 'button']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- TODO: Content desc -->
<?php if ($model->customer) : ?>
    <section class="connect-desk">
    <div class="connect-desk__profile-mini">
        <div class="profile-mini__wrapper">
            <?= Html::tag('h3', \Yii::t('app', 'Customer')); ?>

            <div class="profile-mini__top">
                <?= GenderIcon::widget(['gender' => $model->customer->gender, 'htmlOptions' => ['width' => 62, 'height' => 62, 'alt' => 'Аватар заказчика']]); ?>
                <div class="profile-mini__name five-stars__rate">
                    <?= Html::tag('p', $model->customer->name); ?>
                </div>
            </div>
            <p class="info-customer">
                <?= Html::tag('span', Yii::t('intl', 'tasks.count', ['n' => count($model->customer->customerTasks)])); ?>
                <span class="last-visit">
                    <?= $model->customer->created_at; ?>
                    <?php  //Yii::t('intl', 'users.registered', ['n' => $model->customer->registerDateInterval['y']]); ?>
                </span>
            </p>
            <?= Html::a(Yii::t('app', 'Show Profile'), ['/user/view', 'id' => $model->customer->id], ['class' => 'link-regular']); ?>
        </div>
    </div>
    <div id="chat-container">
        <!-- добавьте сюда атрибут task с указанием в нем id текущего задания-->
        <chat class="connect-desk__chat"></chat>
    </div>
</section>

<?php endif;?>



<!-- TODO: Modal Widget -->
<section class="modal response-form form-modal" id="response-form">
    <h2>Отклик на задание</h2>
    <form action="#" method="post">
        <p>
            <label class="form-modal-description" for="response-payment">Ваша цена</label>
            <input class="response-form-payment input input-middle input-money" type="text" name="response-payment" id="response-payment">
        </p>
        <p>
            <label class="form-modal-description" for="response-comment">Комментарий</label>
            <textarea class="input textarea" rows="4" id="response-comment" name="response-comment" placeholder="Place your text"></textarea>
        </p>
        <button class="button modal-button" type="submit">Отправить</button>
    </form>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
<section class="modal completion-form form-modal" id="complete-form">
    <h2>Завершение задания</h2>
    <p class="form-modal-description">Задание выполнено?</p>
    <form action="#" method="post">
        <input class="visually-hidden completion-input completion-input--yes" type="radio" id="completion-radio--yes" name="completion" value="yes">
        <label class="completion-label completion-label--yes" for="completion-radio--yes">Да</label>
        <input class="visually-hidden completion-input completion-input--difficult" type="radio" id="completion-radio--yet" name="completion" value="difficulties">
        <label class="completion-label completion-label--difficult" for="completion-radio--yet">Возникли проблемы</label>
        <p>
            <label class="form-modal-description" for="completion-comment">Комментарий</label>
            <textarea class="input textarea" rows="4" id="completion-comment" name="completion-comment" placeholder="Place your text"></textarea>
        </p>
        <p class="form-modal-description">
            Оценка
            <div class="feedback-card__top--name completion-form-star">
                <span class="star-disabled"></span>
                <span class="star-disabled"></span>
                <span class="star-disabled"></span>
                <span class="star-disabled"></span>
                <span class="star-disabled"></span>
            </div>
        </p>
        <input type="hidden" name="rating" id="rating">
        <button class="button modal-button" type="submit">Отправить</button>
    </form>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
<section class="modal form-modal refusal-form" id="refuse-form">
    <h2>Отказ от задания</h2>
    <p>
        Вы собираетесь отказаться от выполнения задания.
        Это действие приведёт к снижению вашего рейтинга.
        Вы уверены?
    </p>
    <button class="button__form-modal button" id="close-modal" type="button">Отмена</button>
    <button class="button__form-modal refusal-button button" type="button">Отказаться</button>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
<div class="overlay"></div>

<!-- TODO: Assets -->
<script src="/js/main.js"></script>
<script src="/js/messenger.js"></script>