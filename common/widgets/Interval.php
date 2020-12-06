<?php

namespace common\widgets;

use DateTime;
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

    /** @var string Date on string format */
    public $date;

    /** @var DateTime */
    public $startDate;
    /** @var DateTime */
    public $endDate;

    public function init()
    {
        if (!isset($this->startDate)) {
            $this->startDate = new DateTime();
        }

        if ($this->startDate && !($this->startDate instanceof DateTime)) {
            $this->startDate = new DateTime($this->startDate);
        }

        if ($this->endDate && !($this->endDate instanceof DateTime)) {
            $this->endDate = new DateTime($this->endDate);
        }
    
        parent::init();
    }

    /** {@inheritDoc} */
    public function run(): string
    {
        if ($this->type === 'users.lastlogin') {
            return $this->lastLoginInterval();
        }

        if ($this->type === 'users.years') {
            return self::yearsInterval($this->date);
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

    private static function yearsInterval(string $date): string
    {
        $now = new DateTime();
        $interval = $now->diff(new DateTime($date));

        return \Yii::t('intl', 'users.years', [ 'n' => $interval->y ]);
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
