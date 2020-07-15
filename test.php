<?php
require_once "vendor/autoload.php";
error_reporting(E_ALL);

use app\business\Task;

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

assert($task->getNextStatus(Task::ACTION_PERFORMER_PENDING) === Task::STATUS_INPROGRESS, 'action Pending');
assert($task->getNextStatus(Task::ACTION_PERFORMER_REFUSE) === Task::STATUS_FAIL, 'action Refuse');
assert($task->getNextStatus(Task::ACTION_CUSTOMER_CANCEL) === Task::STATUS_CANCELED, 'action Cancel');
assert($task->getNextStatus(Task::ACTION_CUSTOMER_COMPLETE) === Task::STATUS_COMPLETE, 'action Complete');
assert($task->getNextStatus('Custom') === null, 'action Custom');
