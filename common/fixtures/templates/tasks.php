<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */
return [
    'customer_user_id' => $faker->randomCustomer,
    'city_id' => $faker->biasedNumberBetween(1,1108),
    'category_id' => $faker->biasedNumberBetween(1,8),
    'title' => $faker->text,
    'description' => $faker->realText(),
    'additional_info' => $faker->address
];