<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */

return [
    'user_id' => '', // ID пользователя
    'related_task_id' => '', // ID Исполнителя задания
    'rate' => $faker->numberBetween(1, 5),
    'comment' => $faker->text
];
