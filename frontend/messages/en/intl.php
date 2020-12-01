<?php

/**
 * Yii2 Intl Extension
 * 
 * @see https://www.yiiframework.com/doc/guide/2.0/en/tutorial-i18n
 * @see https://intl.rmcreative.ru/tables?locale=en_US
 */

$gender = 'Was online';

$intervalDays = '{n, plural, =0{today} =1{yesterday} other{# days ago}}';
$intervalHours = '{n, plural, =0{hour left} =1{hour left} other{# hours left}}';
$intervalMinutes = '{n, plural, =0{right now} =1{one minute ago} other{# minutes ago}}';

return [
    /** Intervals */
    'interval.d' => $intervalDays,
    'interval.h' => $intervalHours,
    'interval.i' => $intervalMinutes,
    /** Days */
    'users.lastlogin.d' => "{$gender} {$intervalDays}",
    /** Hours */
    'users.lastlogin.h' => "{$gender} {$intervalHours}",
    /** Minutes */
    'users.lastlogin.i' => "{$gender} {$intervalMinutes}",
    'users.registered' => "{n, plural, =0{one year} =1{one year} other{# years}}; on site",
    'tasks.count' => '{n, plural, =0{no tasks} =1{one task} other{# tasks}}',
    'responses.count' => '{n, plural, =0{# responses} =1{one response} other{# reponses}}'
];
