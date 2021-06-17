<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */

use app\bizzlogic\Task as TaskLogic;

$isHasRemoteWork = $faker->boolean(70);

if ($faker->boolean(45)) {
    $status = TaskLogic::STATUS_COMPLETE;
} elseif ($faker->boolean(45)) {
    $status = TaskLogic::STATUS_INPROGRESS;
} elseif ($faker->boolean(45)) {
    $status = TaskLogic::STATUS_FAIL;
} else {
    $status = TaskLogic::STATUS_NEW;
}

$created = $faker->dateTimeInInterval('now', '-1 months');
$published = $faker->dateTimeInInterval($created, '+30 minutes');


return [
    'user_id' => $faker->randomCustomer(), // Рандомный пользователь
    'performer_user_id' => $status !== TaskLogic::STATUS_NEW ? $faker->randomPerformer() : null,
    'category_id' => $faker->numberBetween(1, 8), // ID катеогрии задания
    'title' => $faker->sentence(6), // Заголовок
    'description' => $faker->text(100), // Описание
    'address' => $isHasRemoteWork ? $faker->address : null,
    'latitude' => $isHasRemoteWork ? $faker->latitude : null,
    'longitude' => $isHasRemoteWork ? $faker->longitude : null,
    'budget' => $faker->optional()->numberBetween(0, 10000),
    'expire' => $faker->boolean() ?  $faker->dateTimeInInterval('+5 days', 'now')->format('Y-m-d H:i:s') : null,
    'created_at' => $created->format('Y-m-d H:i:s'),
    'updated_at' => $published->format('Y-m-d H:i:s'),
    'published_at' => $published->format('Y-m-d H:i:s'),
    'status' => $status
];
