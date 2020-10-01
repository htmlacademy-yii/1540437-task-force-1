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


return [
  'tasks.count'     => '{n, plural, one{# задание} few{# задания} many{# заданий} other{# от задания}}',
  'responses.count' => '{n, plural, one{# отзыв} few{# отзыва} many{# отзывов} other{# от отзыва}}'
];