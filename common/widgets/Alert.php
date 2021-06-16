<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Alert extends \yii\base\Widget
{
    public $options = [];
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - key: the name of the session flash variable
     * - value: the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'error'   => 'alert-danger',
        'danger'  => 'alert-danger',
        'success' => 'alert-success',
        'info'    => 'alert-info',
        'warning' => 'alert-warning'
    ];
    /**
     * @var array the options for rendering the close button tag.
     * Array will be passed to [[\yii\bootstrap\Alert::closeButton]].
     */
    public $closeButton = [];


    public function init()
    {

        \frontend\assets\AlertAssets::register($this->getView());
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {


        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $appendClass = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        if ($flashes) {
            $this->registerJs();
        }

        foreach ($flashes as $type => $flash) {
            if (!isset($this->alertTypes[$type])) {
                continue;
            }

            $options = array_merge($this->options, [
                'id' => $this->getId() . '-' . $type,
                'class' => $this->alertTypes[$type] . $appendClass,
            ]);
            Html::addCssClass($options, 'alert');

            echo Html::beginTag('div', $options);
            foreach ((array) $flash as $message) {
                echo $message;
            }
            echo '<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>';

            echo Html::endTag('div');

            $session->removeFlash($type);
        }
    }

    private function registerJs()
    {
        $js = <<< JS
            document.querySelectorAll('[data-dismiss=alert]').forEach(function(element) {
                element.onclick = function() {
                    element.parentElement.remove();
                }
            });
        JS;

        $this->getView()->registerJs($js, \yii\web\View::POS_READY);
    }
}
