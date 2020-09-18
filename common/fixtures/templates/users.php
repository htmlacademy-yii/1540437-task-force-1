<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */
return [
    'city_id' => $faker->biasedNumberBetween(1,1108),
    'about' => $faker->realText(),
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'email' => $faker->email,
    'role' => $faker->biasedNumberBetween(1, 2),
    'password_hash' => md5($faker->password)
];