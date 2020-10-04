<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */

$gender = $faker->randomElement(['male', 'female']);

return [
    'city_id' => $faker->numberBetween(1, 1108),
    'about' => $faker->text(60),
    'first_name' => $faker->firstName($gender),
    'last_name' => $faker->lastName($gender),
    'email' => $faker->unique()->email,
    'gender' => $gender,
    'created_at' => $faker->dateTimeBetween('-20 days', 'now')->format('Y-m-d H:i:s'),
    'birth_date' => $faker->dateTimeInInterval('-30 years', '+5 years')->format('Y-m-d H:i:s'),
    'last_logined_at' => $faker->dateTimeInInterval('-3 days')->format('Y-m-d H:i:s'),
    'role' => $faker->numberBetween(1, 2),
    'password_hash' => \Yii::$app->security->generatePasswordHash("password_{$index}", 10),
    'phone' => $faker->phoneNumber,
    'skype' => $faker->text(5)
];
