<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */
return [
    'city_id' => $faker->numberBetween(1,1108),
    'about' => $faker->text,
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'email' => $faker->unique()->email,
    'created_at' => $faker->dateTimeBetween('-1 years', 'now')->format('c'),
    'role' => $faker->numberBetween(1,2),
    'password_hash' => \Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    'phone' => $faker->phoneNumber,
];