<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */

$gender = $faker->randomElement(['male', 'female']);

return [
    'city_id' => $faker->numberBetween(1, 1108),
    'profile_id' => $index + 1,
    'gender' => $gender,
    'name' => $faker->firstName($gender) . " " . $faker->lastName($gender),
    'email' => $faker->unique()->email,
    'created_at' => $faker->dateTimeBetween('-20 days', 'now')->format('Y-m-d H:i:s'),
    'last_logined_at' => $faker->dateTimeInInterval('-7 days')->format('Y-m-d H:i:s'),
    'password' => \Yii::$app->security->generateRandomString(12)
];
