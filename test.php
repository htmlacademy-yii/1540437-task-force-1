<?php
require_once 'vendor/autoload.php';
error_reporting(E_ALL);

use app\actions\task\Cancel;
use app\actions\task\Complete;
use app\actions\task\Pending;
use app\actions\task\Refuse;
use app\bizzlogic\Task;

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

/** @var int Заказчик */
$customer = 1;
/** @var int Исполнитель */
$performer = 2;
$task = new Task($customer, $performer);

assert($task->getNextStatus(Pending::internalName()) === Task::STATUS_INPROGRESS, 'action Pending');
assert($task->getNextStatus(Refuse::internalName()) === Task::STATUS_FAIL, 'action Refuse');
assert($task->getNextStatus(Cancel::internalName()) === Task::STATUS_CANCELED, 'action Cancel');
assert($task->getNextStatus(Complete::internalName()) === Task::STATUS_COMPLETE, 'action Complete');

$task = new Task($customer, $performer);
assert($task->actionCancel(Task::ROLE_CUSTOMER, $customer) === Task::STATUS_CANCELED, 'Customer Cancel');

$task = new Task($customer, $performer);
assert($task->actionPending(Task::ROLE_PERFORMER, $performer) === Task::STATUS_INPROGRESS, 'Performer Pending');
assert($task->actionComplete(Task::ROLE_CUSTOMER, $customer) === Task::STATUS_COMPLETE, 'Customer Complete');

$task = new Task($customer, $performer);
assert($task->actionPending(Task::ROLE_PERFORMER, $performer) === Task::STATUS_INPROGRESS, 'Performer Pending');
assert($task->actionRefuse(Task::ROLE_PERFORMER, $performer) === Task::STATUS_FAIL, 'Performer Fail');

$task = new Task($customer, $performer);
try {
    $task->actionPending(Task::ROLE_PERFORMER, $performer);
    $task->actionComplete(Task::ROLE_PERFORMER, $performer);
    echo "Исполнитель не должен иметь прав на Закрытие задания.\n";
} catch (\Exception $e) {
}

$task = new Task($customer, $performer);
try {
    $task->actionComplete(Task::ROLE_PERFORMER, $performer);
    echo "Только Заказчик может Закрыть задачу.\n";
} catch (\Exception $e) {
}
