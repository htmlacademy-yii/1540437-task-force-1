<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */

$gender = $faker->randomElement(['MALE', 'FEMALE']);

return [
    'about' => $faker->text(60),
    'first_name' => $faker->firstName(strtolower($gender)),
    'last_name' => $faker->lastName(strtolower($gender)),
    'gender' => $gender,
    'birth_date' => $faker->dateTimeInInterval('-30 years', '+5 years')->format('Y-m-d H:i:s'),
    'phone' => $faker->phoneNumber,
    'skype' => $faker->text(5)
];
