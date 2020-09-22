<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */
return [
    'customer_user_id' => $faker->randomCustomer,
    'city_id' => $faker->biasedNumberBetween(1,1108),
    'category_id' => $faker->biasedNumberBetween(1,8),
    'title' => $faker->text(20),
    'description' => $faker->text(240),
    'budget' => $faker->biasedNumberBetween(null, 6000),
    'created_at' => $faker->dateTimeBetween('-7 days', 'now')->format('c'),
    'additional_info' => $faker->address
];