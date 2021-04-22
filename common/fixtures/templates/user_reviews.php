<?php

/**
 * @var Faker\Generator $faker
 * @var integer $index
 * @var frontend\models\Task $task
 */


$isCompleteStatus = $faker->randomElement(['COMPLETE', 'FAIL']);

/** @var frontend\models\Task $task */
$task = $faker->getFreeTask();
$performer = $faker->getFreePerformer($task->category_id);
$task->status = $isCompleteStatus;
$task->link('performer', $performer);

if ($performer === null || $task === null) {
    return [];
}

return [
    'user_id' => $task->customer->id, // ID пользователя, что оставил Отзыв
    'related_task_id' => $task->id, // ID Исполнителя задания
    'rate' => $isCompleteStatus === 'FAIL' ? $faker->numberBetween(1, 2) : $faker->numberBetween(3, 5),
    'comment' => $faker->text
];

$bash = "
php yii fixture/generate users, user_profile --count=100 --interactive=0 &&
php yii fixture/load Users --interactive=0 &&
php yii fixture/generate tasks --count=200 --interactive=0 && 
php yii fixture/load Tasks --interactive=0 &&
php yii fixture/generate user_categories --count=35 --interactive=0 &&
php yii fixture/load UserCategories --interactive=0 &&
php yii fixture/generate user_reviews --count=50 --interactive=0 &&
php yii fixture/load UserReviews --interactive=0
";