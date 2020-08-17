<?php
require_once "vendor/autoload.php";

use app\bizzlogic\Task;
use app\exceptions\base\TaskException as BaseTaskException;

echo "\n---- Begin -----\n";
$task = new Task(1, 2);
echo "Сценарий 1: 'Испольнитель' откликнулся, 'Заказчик' подтвердил выполнение:";
try {
    echo "\nStatus after Pending  - '{$task->actionPending(Task::ROLE_PERFORMER)}'";
    echo "\nStatus after Complete - '{$task->actionComplete(Task::ROLE_CUSTOMER)}'";
    echo "\nРезультат: 'Success'";
} catch (BaseTaskException $e) {
    echo "\nСценарий 1: Fail with message '{$e->getMessage()}'";
}

$task = new Task(1, 2);
echo "\n--\n";
echo "Сценарий 2: 'Исполнитель' откликнулся и не смог выполнить задание:";
try {
    echo "\nStatus after actionPending - '{$task->actionPending(Task::ROLE_PERFORMER)}'";
    echo "\nStatus after actionRefuse  - '{$task->actionRefuse(Task::ROLE_PERFORMER)}'";
    echo "\nРезультат: 'Success'";
} catch (BaseTaskException $e) {
    echo "\nРезультат: 'Fail' {$e->getMessage()}";
}

$task = new Task(1, 2);
echo "\n--\n";
echo "Сценарий 3: 'Заказчик' закрыл заявку до начала выполнения.";
try {
    echo "\nStatus after actionComplete - '{$task->actionComplete(Task::ROLE_CUSTOMER)}'";
    echo "\nРезультат: 'Fail'";
} catch (BaseTaskException $e) {
    echo "\nResult: 'Success' {$e->getMessage()}";
}

$task = new Task(1, 2);
echo "\n--\n";
echo "Сценарий 4: 'Заказчик' отменил задачу после начала работы 'Исполнителем'";
try {
    echo "\nStatus after actionPending - '{$task->actionPending(Task::ROLE_PERFORMER)}'";
    echo "\nStatus after actionCancel - '{$task->actionCancel(Task::ROLE_CUSTOMER)}'";
    echo "\nРезультат: 'Fail'";
} catch (BaseTaskException $e) {
    echo "\nРезультат: 'Success' {$e->getMessage()}";
    // echo $e;
}

$task = new Task(1, 2);
echo "\n--\n";
echo "Сценарий 5: 'Исполнитель' отказался от не принятого задания";
try {
    echo "\nStatus after actionRefuse - '{$task->actionRefuse(Task::ROLE_PERFORMER)}'";
    echo "\nРезультат: 'Fail'";
} catch (BaseTaskException $e) {
    echo "\nРезультат: 'Success' {$e->getMessage()}";
}

$task = new Task(1, 20);
echo "\n--\n";
echo "Сценарий 7: 'Заказчик' выбрал второго 'Исполнителя'.";
try {
    echo "\nStatus after actionPending - '{$task->actionPending(Task::ROLE_PERFORMER)}'";
    echo "\nStatus after actionPending - '{$task->actionPending(Task::ROLE_PERFORMER)}'";
    echo "\nРезультат: 'Fail'";
} catch (BaseTaskException $e) {
    echo "\nРезультат: 'Success' {$e->getMessage()}";
}

echo "\n----- End ------\n";
