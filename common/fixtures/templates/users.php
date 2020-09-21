<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */
return [
    'city_id' => $faker->biasedNumberBetween(1,1108),
    'about' => $faker->sentence(20, true),
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'email' => $faker->email,
    'role' => $faker->biasedNumberBetween(1, 2),
    'password_hash' => \Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    'phone' => $faker->phoneNumber,
];