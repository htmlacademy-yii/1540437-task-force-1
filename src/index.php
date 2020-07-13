<?php
error_reporting(E_ALL);
require_once 'Task.php';

$task = new Task(1, 3);



echo "\n---- Begin -----\n";
$task = new Task(1, 2);
echo "Сценарий 1: 'Испольнитель' откликнулся, 'Заказчик' подтвердил выполнение:";
try {
  echo "\nStatus after Pending  - '{$task->actionPending()}'";
  echo "\nStatus after Complete - '{$task->actionComplete()}'";
  echo "\nРезультат: 'Success'";
} catch (BaseTaskException $e) {
  echo "\nСценарий 1: Fail with message '{$e->getMessage()}'";
}

$task = new Task(1, 2);
echo "\n--\n";
echo "Сценарий 2: 'Исполнитель' откликнулся и не смог выполнить задание:";
try {
  echo "\nStatus after actionPending - '{$task->actionPending()}'";
  echo "\nStatus after actionRefuse  - '{$task->actionRefuse()}'";
  echo "\nРезультат: 'Success'";
} catch (BaseTaskException $e) {
  echo "\nРезультат: 'Fail' {$e->getMessage()}";
}

$task = new Task(1, 2);
echo "\n--\n";
echo "Сценарий 3: 'Заказчик' закрыл заявку до начала выполнения.";
try {
  echo "\nStatus after actionCancel - '{$task->actionCancel()}'";
  echo "\nРезультат: 'Success'";
} catch (BaseTaskException $e) {
  echo "\nResult: Fail with message '{$e->getMessage()}'";
}

$task = new Task(1, 2);
echo "\n--\n";
echo "Сценарий 4: 'Заказчик' отменил задачу после начала работы 'Исполнителем'";
try {
  echo "\nStatus after actionPending - '{$task->actionPending()}'";
  echo "\nStatus after actionCancel - '{$task->actionCancel()}'";
  echo "\nРезультат: 'Fail'";
} catch (BaseTaskException $e) {
  echo "\nРезультат: 'Success' {$e->getMessage()}";
}

$task = new Task(1, 2);
echo "\n--\n";
echo "Сценарий 5: 'Исполнитель' отказался от не принятого задания";
try {
  echo "\nStatus after actionRefuse - '{$task->actionRefuse()}'";
  echo "\nРезультат: 'Fail'";
} catch (BaseTaskException $e) {
  echo "\nРезультат: 'Success' {$e->getMessage()}";
}

$task = new Task(1);
echo "\n--\n";
echo "Сценарий 6: 'Заказчик' выполнил задание без 'Исполнителя'";
try {
  echo "\nStatus after actionPending - '{$task->actionPending()}'";
  echo "\nStatus after actionComplete - '{$task->actionComplete()}'";
  echo "\nРезультат: 'Fail'";
} catch (BaseTaskException $e) {
  echo "\nРезультат: 'Success' {$e->getMessage()}";
}

$task = new Task(1, 20);
echo "\n--\n";
echo "Сценарий 7: 'Заказчик' выбрал второго 'Исполнителя'.";
try {
  echo "\nStatus after actionPending - '{$task->actionPending()}'";
  echo "\nStatus after actionPending - '{$task->actionPending()}'";
  echo "\nРезультат: 'Fail'";
} catch (BaseTaskException $e) {
  echo "\nРезультат: 'Success' {$e->getMessage()}";
}

echo "\n----- End ------\n";
