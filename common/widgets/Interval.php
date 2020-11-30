<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\base\Widget;

class Interval extends Widget
{
    /** 
     * Заменяет сообщение по умолчанию для текущего
     * виджета если `NULL` записей.
     * 
     * {@inheritDoc}
     */
    public $nullDisplay = '';

    /** @var string Тэг, по умолчанию `span` */
    public $interval;


    /** {@inheritDoc} */
    public function run(): string
    {
        // $html = '';
        // for ($i = 0; $i < $this->max; $i++) {
        //     $isEmptyStar = floor($this->rating) <= $i;
        //     $html .= $this->renderStar($isEmptyStar);
        // }

        // if ($this->showRating && is_numeric($this->rating)) {
        //     $html .= \Yii::$app->formatter->asDecimal($this->rating, 2);
        // }

        return $this->renderInterval();
    }

    private function renderInterval(): string
    {
        if ($this->interval['d'] >= 1) {
            return \Yii::t('intl', 'interval.d', ['n' => $this->interval['d']]);
        } elseif ($this->interval['h'] > 0) {
            return \Yii::t('intl', 'interval.h', ['n' => $this->interval['h']]);
        } elseif ($this->interval['i'] >= 0) {
            return \Yii::t('intl', 'interval.i', ['n' => $this->interval['i']]);
        }
    }
}
