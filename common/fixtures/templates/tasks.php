<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */
return [
    'customer_user_id' => $faker->unique()->numberBetween(1, 50),
    'city_id' => $faker->numberBetween(1, 1108),
    'category_id' => $faker->numberBetween(1, 8),
    'title' => $faker->text(20),
    'description' => $faker->text(240),
    'budget' => $faker->numberBetween(1000, 6000),
    'created_at' => $faker->dateTimeBetween('-7 days', 'now')->format('Y-m-d H:i:s'),
    'additional_info' => $faker->address
];
