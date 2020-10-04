<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 */
return [
  'task_id' => $faker->EmptyTasks,
  'user_id' => $faker->randomPerformer,
  'price' => $faker->numberBetween(1000, 6000),
  'comment' => $faker->text,
  'evaluation' => $faker->numberBetween(1, 5),
  'is_success' => $faker->boolean(70)
];
