<?php
/**
 * Yii2 Intl Extension
 * @see https://www.yiiframework.com/doc/guide/2.0/ru/tutorial-i18n
 *
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

$gender = 'Was online';

return [
    /** Days */
    'users.lastlogin.d' => "{$gender} {n, plural, =0{today} =1{yesterday} other{# days ago}}",
    /** Hours */
    'users.lastlogin.h' => "{$gender} {n, plural, =0{hour left} =1{hour left} other{# hours left}}",
    /** Minutes */
    'users.lastlogin.i' => "{$gender} {n, plural, =0{right now} =1{one minute ago} other{# minutes ago}}",
    'tasks.count' => '{n, plural, =0{no tasks} =1{one task} other{# tasks}}',
    'responses.count' => '{n, plural, =0{# responses} =1{one response} other{# reponses}}'
];
