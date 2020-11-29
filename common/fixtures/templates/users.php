<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */

return [
    'city_id' => $faker->numberBetween(1, 1108),
    'profile_id' => $index + 1,
    'email' => $faker->unique()->email,
    'created_at' => $faker->dateTimeBetween('-20 days', 'now')->format('Y-m-d H:i:s'),
    'last_logined_at' => $faker->dateTimeInInterval('-3 days')->format('Y-m-d H:i:s'),
    'password_hash' => \Yii::$app->security->generatePasswordHash("password_{$index}", 4)
];
