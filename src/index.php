<?php
error_reporting(E_ALL);
// ini_set('zend.assertions', -1);
require_once 'Task.php';


$task1 = new Task();

if ($task1->actionCreate()) {
  echo "Задача #{$task1->id} успешно опубликована. Статус: '{$task1->status}'\n";
}

if ($task1->actionPending()) {
  echo "Поступила новая заявка на выполенение. Статус: '{$task1->status}'\n";
}

if ($task1->actionPending()) {
  echo "Поступила новая заявка на выполенение. Статус: '{$task1->status}'\n";
}

if ($task1->actionApprove()) {
  echo "Заказчик выбрал исполнителя. Статус: '{$task1->status}'\n";
}

if ($task1->actionApprove()) {
  echo "Заказчик выбрал исполнителя. Статус: '{$task1->status}'\n";
} else {
  echo "Заказчику не удалось выбрать исполнителя. Статуc не изменился: '{$task1->status}'\n";
}

if ($task1->actionComplete()) {
  echo "Исполнитель подтвердил что задача Выполнена. Статус: '{$task1->status}'\n";
}





