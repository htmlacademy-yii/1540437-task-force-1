<?php
namespace common\components;

use Yii;
use yii\i18n\Formatter as I18nFormatter;

class Formatter extends I18nFormatter
{
    /** 
     * Форматировать как интервал по типу
     * 
     * @param string $type DateTimeInterval Type y|d|h|i
     */
    public function asInterval(string $type = 'y', $start, $end = 'now'): string
    {
        $start = new \DateTime($start);
        $end = new \DateTime($end);

        $interval = $end->diff($start);

        if ($type === 'auto') {
            $type = self::autoType($interval);
        }

        return Yii::t('intl', "interval.{$type}", [ 'n' => $interval->{$type} ]);
    }

    public function asDateInterval(string $start, string $end = 'now')
    {
        $start = new \DateTime($start);
        $end = new \DateTime($end);

        return (array) $end->diff($start);
    }

    /**
     * Auto type
     *
     * @param \DateInterval $interval
     * @return string
     */
    private static function autoType(\DateInterval $interval): string
    {
        if ($interval->y > 0) {
            return 'y';
        } elseif ($interval->d > 0) {
            return 'd';
        } elseif ($interval->h > 0) {
            return 'h';
        } else {
            return 'i';
        }
    }
}