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

try {
    $task = new Task($customer, $performer);
    // assert($task->pending($customer) === false, 'Customer Pending');
    assert($task->pending($performer) === true, 'Performer Pending');
    // assert($task->refuse($customer) === false, 'Customer refuse');
    assert($task->refuse($performer) === true, 'Performer refuse');
    // assert($task->cancel($performer) === false, 'Performer Cancel');
    // assert($task->cancel($customer) === false, 'Customer Cancel');
} catch (Throwable $e) {
    echo $e;
}
