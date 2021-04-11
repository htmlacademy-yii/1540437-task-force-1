<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */

$gender = $faker->randomElement(['MALE', 'FEMALE']);

return [
    'city_id' => $faker->numberBetween(1, 1108),
    'profile_id' => $index + 1,
    'name' => $faker->name($gender),
    'gender' => $gender,
    'email' => $faker->unique()->email,
    'created_at' => $faker->dateTimeBetween('-20 days', 'now')->format('Y-m-d H:i:s'),
    'last_logined_at' => $faker->dateTimeInInterval('-7 days')->format('Y-m-d H:i:s'),
    'password' => \Yii::$app->security->generateRandomString(12)
];
