<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */

return [
    'user_id' => $faker->numberBetween(1, 50),
    'category_id' => $faker->randomCategory()
];
