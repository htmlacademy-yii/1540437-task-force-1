<?php
/**
 * @var Faker\Generator $faker
 * @var integer $index
 */

$isRemoteWork = $faker->boolean(70);
$isExpire = $faker->boolean(20);

return [
    'user_id' => $faker->numberBetween(1, 30), // Рандомный пользователь
    'category_id' => $faker->numberBetween(1, 8), // ID катеогрии задания
    'performer_user_id' => null, // NULL или Рандомный пользователь с ролью "исполнитель"
    'title' => $faker->sentence(6), // Заголовок
    'description' => $faker->text(100), // Описание
    'address' => $isRemoteWork ? $faker->address : null,
    'latitude' => $isRemoteWork? $faker->latitude : null,
    'longitude' => $isRemoteWork ? $faker->longitude : null,
    'budget' => $faker->optional(0.7)->numberBetween(0, 10000),
    'expire' => $isExpire ?  $faker->dateTimeInInterval('+5 days', 'now')->format('Y-m-d H:i:s') : null,
    'created_at' => $faker->dateTimeInInterval('now', '-1 months')->format('Y-m-d H:i:s')
];