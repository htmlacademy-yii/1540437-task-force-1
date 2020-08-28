<?php
require_once 'vendor/autoload.php';
error_reporting(E_ALL);

use app\actions\task\Cancel;
use app\actions\task\Complete;
use app\actions\task\Pending;
use app\actions\task\Refuse;
use app\bizzlogic\Task;
use app\components\FakeRelations;
use app\components\SqlGenerator;
use app\faker\FakeCategories;
use app\faker\FakeCities;
use app\faker\FakeProfile;
use app\faker\FakeTasks;
use app\faker\FakeTasksResponses;
use app\faker\FakeUser;
use app\faker\FakeUserApinions;

function assertHandler($file, $line, $code, $desc = null)
{
    echo "Неудачная проверка утверждения в $file:$line";
    if ($desc) {
        echo ":Decription: {$desc}";
    }
    echo "\n";
}

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);
assert_options(ASSERT_CALLBACK, 'assertHandler');

/** @var int ID Заказчика */
$customer = 1;
/** @var int ID Исполнителя */
$performer = 2;
$task = new Task($customer, $performer);

assert($task->getNextStatus(new Pending) === Task::STATUS_INPROGRESS, 'action Pending');
assert($task->getNextStatus(new Refuse) === Task::STATUS_FAIL, 'action Refuse');
assert($task->getNextStatus(new Cancel) === Task::STATUS_CANCELED, 'action Cancel');
assert($task->getNextStatus(new Complete) === Task::STATUS_COMPLETE, 'action Complete');

$task = new Task($customer, $performer);
assert($task->cancel($customer) === true, 'Customer Cancel');
assert($task->cancel($performer) === false, 'Performer Cancel');

assert($task->pending($performer) === false, 'Performer Pending');
assert($task->pending($customer) === false, 'Customer Pending');

assert($task->refuse($performer) === false, 'Performer Refuse');
assert($task->refuse($customer) === false, 'Customer Refuse');

$task = new Task($customer, $performer);
// assert($task->pending($customer) === false, 'Customer Pending');
assert($task->pending($performer) === true, 'Performer Pending');

// assert($task->refuse($customer) === false, 'Customer refuse');
assert($task->refuse($performer) === true, 'Performer refuse');

// assert($task->cancel($performer) === false, 'Performer Cancel');
// assert($task->cancel($customer) === false, 'Customer Cancel');

try {
    $fakeRelations = new FakeRelations();
    $sqlGenerator = new SqlGenerator('taskforce');

    $cities = FakeCities::importFromFile('data/cities.csv');
    $categories = FakeCategories::importFromFile('data/categories.csv');

    $users = FakeUser::importFromFile('data/users.csv');
    $userProfiles = FakeProfile::importFromFile('data/profiles.csv');

    $tasks = FakeTasks::importFromFile('data/tasks.csv');
    $taskResponses = FakeTasksResponses::importFromFile('data/replies.csv');
    $userOpinions = FakeUserApinions::importFromFile('data/opinions.csv');

    $users = $fakeRelations->mergeWith($users, $userProfiles);
    $users = $fakeRelations->setRelation($users, $cities, ['city_id' => 'id']);

    $tasks = $fakeRelations->setRelation($tasks, $users, ['customer_user_id' => 'id']);
    $tasks = $fakeRelations->setRelation($tasks, $cities, ['city_id' => 'id']);

    $userOpinions = $fakeRelations->setRelation($userOpinions, $users, ['user_id' => 'id']);
    $userOpinions = $fakeRelations->setRelation($userOpinions, $tasks, ['refer_task_id' => 'id']);

    $taskResponses = $fakeRelations->setRelation($taskResponses, $users, ['user_id' => 'id']);
    $taskResponses = $fakeRelations->setRelation($taskResponses, $tasks, ['task_id' => 'id']);

    $data = $sqlGenerator->disbaleForeignKeyCheks();
    $data .= $sqlGenerator->truncateByModel($tasks);
    $data .= $sqlGenerator->truncateByModel($users);
    $data .= $sqlGenerator->truncateByModel($cities);
    $data .= $sqlGenerator->truncateByModel($categories);
    $data .= $sqlGenerator->truncateByModel($userOpinions);
    $data .= $sqlGenerator->truncateByModel($taskResponses);
    $data .= $sqlGenerator->enableForeignKeyCheks();

    $data .= $sqlGenerator->batchInsert($categories);
    $data .= $sqlGenerator->batchInsert($cities);
    $data .= $sqlGenerator->batchInsert($users);
    $data .= $sqlGenerator->batchInsert($tasks);
    $data .= $sqlGenerator->batchInsert($userOpinions);
    $data .= $sqlGenerator->batchInsert($taskResponses);

    $file = new \SplFileObject('src/sql/export.sql', 'w');
    $file->ftruncate(0);
    $file->fwrite($data);
} catch (Throwable $e) {
    echo $e . PHP_EOL;
}

// $task = new Task($customer, $performer);
// assert($task->actionPending($performer) === true, 'Performer Pending');
// assert($task->actionComplete($customer) === true, 'Customer Complete');

// $task = new Task($customer, $performer);
// assert($task->actionPending($performer) === true, 'Performer Pending');
// assert($task->actionRefuse($performer) === true, 'Performer Fail');

// $task = new Task($customer, $performer);
// try {
//     $task->actionPending($performer);
//     $task->actionComplete($performer);
//     echo "Исполнитель не должен иметь прав на Закрытие задания.\n";
// } catch (\Exception $e) {
// }

// $task = new Task($customer, $performer);
// try {
//     $task->actionComplete($performer);
//     echo "Только Заказчик может Закрыть задачу.\n";
// } catch (\Exception $e) {
// }
