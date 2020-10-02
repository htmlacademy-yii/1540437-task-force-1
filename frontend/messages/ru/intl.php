<?php
/**
 * Yii2 Intl Extension
 * 
 * @see https://www.yiiframework.com/doc/guide/2.0/ru/tutorial-i18n
 * @see https://intl.rmcreative.ru/general/ru_RU
 *
 * Plural вариаации
 *
 * =0 означает ноль;
 * =1 соответствует ровно 1;
 * one — 21, 31, 41 и так далее;
 * few — от 2 до 4, от 22 до 24 и так далее;
 * many — 0, от 5 до 20, от 25 до 30 и так далее;
 * other — для всех прочих чисел (например, дробных).
 */

$gender = '{gender, select, male{Был} female{Была} other{Был}}';
$intervalDays = '{n, plural, =0{сегодня} =1{вчера} one{# день назад} few{# дня назад} many{# дней назад} other{# дня назад}}';
$intervalHours = '{n, plural, =0{менее часа назад} =1{час назад} one{# час назад} few{# часа назад} many{# часов назад} other{# часа назад}}';
$intervalMinutes = '{n, plural, =0{только что} =1{минуту назад} one{# минуту назад} few{# минуты назад} many{# минут назад} other{# минуты назад}}';


return [
    /** Интервалы */
    'interval.d' => $intervalDays,
    'interval.h' => $intervalHours,
    'interval.i' => $intervalMinutes,
    /** Дней */
    'users.lastlogin.d' => "{$gender} на сайте {$intervalDays}",
    /** Часы */
    'users.lastlogin.h' => "{$gender} на сайте {$intervalHours}",
    /** Минуты */
    'users.lastlogin.i' => "{$gender} на сайте {$intervalMinutes}",
    /** Другое */
    'tasks.count' => '{n, plural, one{# задание} few{# задания} many{# заданий} other{# от задания}}',
    'responses.count' => '{n, plural, one{# отзыв} few{# отзыва} many{# отзывов} other{# от отзыва}}',
    
];
