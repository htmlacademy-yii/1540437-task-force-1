<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */

return [
    'about' => $faker->text(60),
    'birth_date' => $faker->dateTimeInInterval('-30 years', '+5 years')->format('Y-m-d H:i:s'),
    'phone' => $faker->phoneNumber,
    'skype' => $faker->text(5),
    'telegramm' => $faker->lexify('@?????'),
    'views' => $faker->numberBetween(0, 300),
    'address' => $faker->address
];
