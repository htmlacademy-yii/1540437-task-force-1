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

        $intlType = 'interval.' . $type;

        return Yii::t('intl', $intlType, [ 'n' => $end->diff($start)->{$type} ]);
    }
}