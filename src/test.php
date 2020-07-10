<?php
error_reporting(E_ALL);
require_once 'Task.php';

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

$task1 = new Task(1, 6);

assert($task1->actionPending() === Task::STATUS_INPROGRESS, 'Task 1: 1.actionPending');
assert($task1->actionComplete() === Task::STATUS_COMPLETE, 'Task 1: 2.actionComplete');
assert($task1->actionPending() === Task::STATUS_COMPLETE, 'Task 1: 3.actionPending');
