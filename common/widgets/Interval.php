<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\base\Widget;

/**
 * @property string $interval
 */
class Interval extends Widget
{
    /** 
     * Заменяет сообщение по умолчанию для текущего
     * виджета если `NULL` записей.
     * 
     * {@inheritDoc}
     */
    public $nullDisplay = '';
    public $interval;
    public $user;
    public $gender;

    public $type;


    /** {@inheritDoc} */
    public function run(): string
    {
        if ($this->type = 'users.lastlogin') {
            return $this->lastLoginInterval();
        }
        return $this->renderInterval();
    }

    private function lastLoginInterval()
    {
        if ($this->interval['d'] > 0) {
            return \Yii::t('intl', 'users.lastlogin.d', ['gender' => strtolower($this->gender), 'n' => $this->interval['d']]);
        } elseif ($this->interval['h'] > 0) {
            return \Yii::t('intl', 'users.lastlogin.h', ['gender' => strtolower($this->gender), 'n' => $this->interval['h']]);
        } elseif ($this->interval['i'] >= 0) {
            return \Yii::t('intl', 'users.lastlogin.i', ['gender' => strtolower($this->gender), 'n' => $this->interval['i']]);
        }
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
