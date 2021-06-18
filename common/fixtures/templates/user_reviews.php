<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 * @var frontend\models\Task $task
 */

$completedTasks = $faker->completedTasks();

if ($completedTasks === null) {
    return null;
}

$data = [
    'user_id' => $completedTasks->user_id, // ID пользователя, что оставил Отзыв
    'related_task_id' => $completedTasks->id, // ID Исполнителя задания
    'comment' => $faker->text
];

if ($completedTasks->status === \app\bizzlogic\Task::STATUS_FAIL) {
    $data['rate'] = $faker->numberBetween(1, 3);
} else {
    if ($faker->boolean(10)) {
        return null;
    }
    $data['rate'] = $faker->numberBetween(4, 5);
}

return $data;
