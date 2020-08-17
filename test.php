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

$task = new Task(1, 6);
$userId = 1;

assert($task->getNextStatus(Pending::internalName()) === Task::STATUS_INPROGRESS, 'action Pending');
assert($task->getNextStatus(Refuse::internalName()) === Task::STATUS_FAIL, 'action Refuse');
assert($task->getNextStatus(Cancel::internalName()) === Task::STATUS_CANCELED, 'action Cancel');
assert($task->getNextStatus(Complete::internalName()) === Task::STATUS_COMPLETE, 'action Complete');

assert($task->actionCancel(Task::ROLE_CUSTOMER, $userId) === true, 'Action Cancel by Customer');
