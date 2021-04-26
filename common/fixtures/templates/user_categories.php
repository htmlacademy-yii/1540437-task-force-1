<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */

return [
    'user_id' => $faker->getCustomer()->id,
    'category_id' => $faker->numberBetween(1, 8),
];
